<?php
App::uses('AppController', 'Controller');

class BackedProjectsController extends AppController
{
    public $uses = ['Project', 'BackedProject', 'BackingLevel'];
    public $components = ['Stripe', 'Mail'];
    public $helpers = ['Setting'];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('hoge');
        if ($this->action === 'card') {
            $this->Security->validatePost = false;
            $this->Security->csrfCheck = false;
        }
    }

    /**
     * 支援金額・支援コメント入力画面
     *
     * @param int $backing_level_id (支援パターン)
     * @param int $project_id       (支援対象PJ)
     */
    public function add($backing_level_id = null, $project_id = null)
    {
        list($pj, $bl) = $this->_init_check($project_id, $backing_level_id);
        if (!$pj || !$bl) return $this->redirect('/');
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!$this->_check_invest_amount_etc($bl)) return;
            $fields = ['name'];
            if ($bl['BackingLevel']['delivery'] == 2) {
                $fields = ['name', 'receive_address'];
            }
            $this->User->id = $this->Auth->user('id');
            if (!$this->User->save($this->request->data, true, $fields)) {
                return $this->Session->setFlash('登録できませんでした。恐れ入りますが再度お試しください。');
            }
            $this->_set_backed_info_to_session($project_id, $backing_level_id);
            $this->redirect(['action' => 'card']);
        } else {
            $this->request->data['User']['receive_address'] = $this->auth_user['User']['receive_address'];
            $this->request->data['User']['name'] = $this->auth_user['User']['name'];
        }
    }

    private function getPayInfoFromSession()
    {
        $bp = $this->Session->read('backed_project');
        if (empty($bp)) return [null, null, null];
        $this->set('backed_project', $bp);
        list($pj, $bl) = $this->_init_check($bp['pj_id'], $bp['bl_id']);
        if (!$pj || !$bl) return [null, null, null];
        return [$bp, $pj, $bl];
    }

    /**
     * カード入力・決済画面
     */
    public function card()
    {
        list($bp, $pj, $bl) = $this->getPayInfoFromSession();
        if (empty($bp)) return $this->redirect('/');
        //決済実行
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Project->begin();
            //プロジェクトの支援金額・支援人数を更新
            if ($pj = $this->Project->add_backed_to_project($bp, $pj)) {
                //支援パターンの購入数を更新
                if ($this->BackingLevel->put_backing_level_now_count($bl)) {
                    //決済
                    $charge_id = $this->_pay($this->request->data, $bp);
                    if (!empty($charge_id)) {
                        $bp = $this->_save_bp($bp, $charge_id);
			$aws = $bp['BackedProject']['invest_amount'];//この値が次で必要
		$id_s = $bp['BackedProject']['user_id'];
		$p_id = $bp['BackedProject']['project_id'];
			$_SESSION['aws'] = $aws;	
		$_SESSION['id_s'] = $id_s;
		$_SESSION['p_id'] = $p_id;
                        $this->Project->commit();
                        $this->_mail_back_complete($bp, $pj);
                        $this->Session->setFlash('ありがとうございます！支援が完了しました！');
                        $this->redirect('thank');//thankページにリダイレクトする
                        
                    }
                }
            }
            $this->Project->rollback();
            $this->Session->setFlash('決済登録に失敗しました。恐れ入りますが、再度お試しください。');
        }
        //利用可能決済手段に応じて画面を変更
        if (AVAILABLE_PAYMENT_METHOD === 'MONEY') {
            return $this->render('money');
        }
    }

    /**
     * 銀行振込でお支払
     * - 支援確定ボタンを押したら、入金があったとみなしてプロジェクトの支援総額等に反映する
     */
    public function bank()
    {
        list($bp, $pj, $bl) = $this->getPayInfoFromSession();
        if (empty($bp)) return $this->redirect('/');
        if (!$this->request->is('post') && !$this->request->is('put')) {
            return $this->redierct('/backed_proejcts/card');
        }
        $this->Project->begin();
        //プロジェクトの支援金額・支援人数を更新
        if ($pj = $this->Project->add_backed_to_project($bp, $pj)) {
            //支援パターンの購入数を更新
            if ($this->BackingLevel->put_backing_level_now_count($bl)) {
                //決済
                $charge_id = null; //銀行振込なのでnull
                $bp = $this->_save_bp($bp, $charge_id, 'bank');
		$aws = $bp['BackedProject']['invest_amount'];//この値が次で必要
		$id_s = $bp['BackedProject']['user_id'];
		$p_id = $bp['BackedProject']['project_id'];
		$_SESSION['aws'] = $aws;	
		$_SESSION['id_s'] = $id_s;
		$_SESSION['p_id'] = $p_id;
		$this->Project->commit();
                $this->_mail_back_complete($bp, $pj);
                $this->Session->setFlash('ありがとうございます！支援が完了しました！');
                $this->redirect('thank');
            }
        }
        $this->Project->rollback();
        $this->Session->setFlash('決済登録に失敗しました。恐れ入りますが、再度お試しください。');
    }



       /**
	*タグ用にサンクスページ追加 
	*/
	public function thank() {
		$this->set('aws', $_SESSION['aws']);
		$this->set('id_s', $_SESSION['id_s']);
		$this->set('p_id' , $_SESSION['p_id']);
		$this->set('cid' , $_SESSION['cid']);
        }   








    /**
     * Stripeで決済（売上確定処理・顧客登録なし）
     */
    private function _pay($data, $bp)
    {
        if (empty($data['token'])) return false;
        return $this->Stripe->payForAllIn($bp['amount'], $data['token'], 'All In');
    }

    /**
     * project、backingLevelの有効性チェック
     */
    private function _init_check($project_id, $backing_level_id)
    {
        if (empty($this->auth_user['User']['email'])) {
            $this->Session->setFlash('支援には事前にメールアドレス認証を完了いただく必要がございます。');
            return false;
        }
        $project = $this->Project->check_backing_enable($project_id);
        if (!$project) {
            return false;
        }
        $backing_level = $this->BackingLevel->check_backing_level($backing_level_id, $project_id);
        if (!$backing_level) {
            return false;
        }
        $this->set(compact('backing_level', 'project'));
        return [
            $project, $backing_level
        ];
    }

    /**
     * 支援金額やリターン配送先住所の入力チェック
     */
    private function _check_invest_amount_etc($backing_level)
    {
        //支援金額のチェック
        $data = $this->request->data;
        if (empty($data['BackedProject']['invest_amount'])) {
            $this->set('error', '支援金額を入力してください。');
            return false;
        }
        $invest_amount = $data['BackedProject']['invest_amount'];
        if (!$this->BackingLevel->check_invest_amount($backing_level, $invest_amount)) {
            $this->set('error', '最低支援金額以上の金額を入力してください');
            return false;
        }
        if (!$this->BackingLevel->check_max_count($backing_level)) {
            $this->set('error', 'OUT OF STOCK!');
            return false;
        }
        //配送方法が郵送で、配送先が空の場合はエラー
        $delivery = $backing_level['BackingLevel']['delivery'];
        if ($delivery == 2) {
            if (empty($data['User']['receive_address'])) {
                $this->Session->setFlash('リターン配送先住所を入力してください');
                return false;
            }
            if (empty($data['User']['name'])) {
                $this->Session->setFlash('氏名を入力してください');
                return false;
            }
        }
        return true;
    }

    /**
     * 支援情報をセッションに保存
     */
    private function _set_backed_info_to_session($project_id, $backing_level_id)
    {
        $bp = [
            'user_id' => $this->Auth->user('id'), 'pj_id' => $project_id, 'bl_id' => $backing_level_id,
            'amount' => $this->request->data['BackedProject']['invest_amount'],
            'comment' => $this->request->data['BackedProject']['comment']
        ];
        $this->Session->write('backed_project', $bp);
    }

    /**
     * 決済時のBackedProjectへのデータ登録関数
     *
     * @param array  $bp
     * @param string $charge_id
     *
     * @return boolean
     */
    private function _save_bp($bp, $charge_id, $payMethod = 'card')
    {
        $bp = [
            'BackedProject' => [
                'stripe_charge_id' => $charge_id,
                'user_id' => $bp['user_id'],
                'project_id' => $bp['pj_id'],
                'backing_level_id' => $bp['bl_id'],
                'invest_amount' => $bp['amount'],
                'comment' => $bp['comment'],
                'status' => STATUS_SUCCESS
            ]
        ];
        if ($payMethod === 'bank') {
            $bp['BackedProject']['bank_flag'] = 1;
            $bp['BackedProject']['bank_paid_flag'] = 0;
        }
        $this->BackedProject->create();
        if ($this->BackedProject->save($bp)) {
            $this->Session->delete('backed_project');
            return $this->BackedProject->read();
        } else {
            $this->log('決済後のBackedProjectへのデータ登録が失敗しました。');
            $this->log($bp);
            return false;
        }
    }

    /**
     * プロジェクトオーナーと管理者と支援者に支援完了の連絡メールを送信する関数
     *
     * @param array $backed_project
     * @param array $project
     *
     * @return boolean
     */
    private function _mail_back_complete($backed_project, $project)
    {
        $owner = $this->User->findById($project['Project']['user_id']);
        $backer = $this->User->findById($backed_project['BackedProject']['user_id']);
        $this->Mail->back_complete_owner($owner, $backer, $project, $backed_project, 'admin');
        $this->Mail->back_complete_owner($owner, $backer, $project, $backed_project, 'user');
        $this->Mail->back_complete_backer($backer, $project, $backed_project);
        return true;
    }

}
