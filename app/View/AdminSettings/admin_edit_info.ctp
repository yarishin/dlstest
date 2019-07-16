<div class="setting_title">
    <h2>基本情報の設定</h2>
</div>

<div class="container">
    <?php echo $this->Form->create('Setting', [
        'type' => 'file', 'inputDefaults' => ['class' => 'form-control']
    ]) ?>

    <div class="col-md-6">
        <h4>サイト情報</h4>
        <div class="form-group">
            <?php echo $this->Form->input('site_name', ['label' => 'サイト名']) ?>
        </div>

        <div class="form-group">
            <label>手数料率</label><br>
            <p>
                プロジェクトが成功した場合の支援総額に対する手数料率。
            </p>
            <div class="input-group">
                <?php echo $this->Form->input('fee', ['label' => false]) ?>
                <span class="input-group-addon">%</span>
            </div>
        </div>

        <h4>メール</h4>
        <div class="form-group">
            <?php echo $this->Form->input('from_mail_address', ['label' => '送信元メールアドレス']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('admin_mail_address', ['label' => '管理者通知用メールアドレス']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('mail_signature', ['label' => 'メールの署名']) ?>
        </div>

        <h4>運営者情報</h4>
        <div class="form-group">
            <?php echo $this->Form->input('company_name', ['label' => '事業者']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('company_type', [
                'label' => '法人 or 個人', 'type' => 'select', 'options' => Configure::read('COMPANY_TYPE')
            ]) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('company_url', ['label' => '運営者URL']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('company_ceo', ['label' => '運営責任者氏名']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('company_address', ['label' => '所在地']) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('company_tel', ['label' => '電話番号']) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('copy_right', ['label' => 'コピーライトに表示する名前']) ?>
        </div>

        <h4>HTMLヘッダ</h4>
        <div class="form-group">
            <?php echo $this->Form->input('site_title', ['label' => 'タイトル']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('site_description', ['label' => 'サイトの説明']) ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('site_keywords', ['label' => 'サイトのキーワード']) ?>
        </div>
    </div>

    <div class="col-md-6">
        <h4>Stripe</h4>
        <h5>動作モード</h5>
        <div class="form-group">
            <?php echo $this->Form->input('stripe_mode', [
                'label' => 'Stripe 動作モード', 'type' => 'select',
                'options' => [0 => 'テストモード', 1 => '本番モード']
            ]) ?>
        </div>
        <h5>本番用Key</h5>
        <div class="form-group">
            <?php echo $this->Form->input('stripe_key', [
                'type' => 'text', 'label' => 'Stripe 公開可能キー（本番用）'
            ]) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('stripe_secret',
                ['label' => 'Stripe シークレットキー（本番用）']) ?>
        </div>
        <h5>テスト用Key</h5>
        <div class="form-group">
            <?php echo $this->Form->input('stripe_test_key', [
                'type' => 'text', 'label' => 'Stripe 公開可能キー（テスト用）'
            ]) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('stripe_test_secret',
                ['label' => 'Stripe シークレットキー（テスト用）']) ?>
        </div>

        <h4>Twitter</h4>
        <p>Twitterログインに必要となります。</p>
        <div class="form-group">
            <?php echo $this->Form->input('twitter_api_key', ['label' => 'Twitter API Key']) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('twitter_api_secret', ['label' => 'Twitter API Secret']) ?>
        </div>

        <h4>Facebook</h4>
        <p>Facebookログインに必要となります。</p>
        <div class="form-group">
            <?php echo $this->Form->input('facebook_api_key', ['label' => 'Facebook API Key']) ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('facebook_api_secret', ['label' => 'Faceook API Key']) ?>
        </div>
        <div class="form-group">
            <label style="margin-bottom:15px;">Facebookでシェアされたときに表示する画像(推奨サイズ：750px x 393px)</label><br>
            <?php echo $this->Form->input('facebook_img', [
                'label' => false, 'type' => 'file', 'class' => ''
            ]) ?>
            <br>
            <?php
            if (!empty($setting['facebook_img'])) {
                echo $this->Label->image($setting['facebook_img'], ['class' => 'img img-responsive']);
            }
            ?>
        </div>

        <h4>Google Analytics コード</h4>
        <div class="form-group">
            <?php echo $this->Form->input('google_analytics', ['label' => 'Google Analytics code', 'type' => 'textarea']) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-1 col-xs-10">
            <br><?php echo $this->Form->submit('登録', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    <?php echo $this->Form->end() ?>
</div>

