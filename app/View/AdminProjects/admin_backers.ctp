<?php echo $this->Html->css('grid', null, ['inline' => false]) ?>
<?php echo $this->Html->script('grid_position', ['inline' => false]) ?>

<div class="bread">
    <?php echo $this->Html->link('プロジェクト', '/admin/admin_projects/') ?> &gt;
    <?php echo $this->Html->link('支援の管理', '/admin/admin_projects/open_projects') ?> &gt;
    支援者一覧
</div>
<div class="setting_title">
    <h2>『<?php echo h($project['Project']['project_name']) ?>』の支援者一覧</h2>
</div>
<?php echo $this->element('admin/setting_project_main_menu', ['mode' => 'back']) ?>
<br>
<div class="row">
    <div class="col-md-8" style="font-size:18px;font-weight:bold;">
        <p>　支援者数：<?php echo number_format(h($project['Project']['backers'])) ?>人</p>
    </div>
    <div class="col-md-4">
        <a href="<?php echo $this->Html->url('/admin/admin_projects/csv_backers/' . h($project['Project']['id'])) ?>"
           class="btn btn-primary">
            CSVダウンロード
        </a>
        <a href="<?php echo $this->Html->url('/admin/admin_projects/edit_level/' . h($project['Project']['id'])) ?>"
           class="btn btn-info" target="_blank">
            支援パターン一覧
        </a>
    </div>
</div>
<br>

<table class="table table-bordered" style="text-align:center;">
    <tr style="background:#3bd;color:#000;font-weight:bold;">
        <td>ステータス</td>
        <td>決済方法</td>
        <td>Stripe Charge ID</td>
        <td>入金状況</td>
        <td>ユーザー名</td>
        <td>氏名</td>
        <td>メールアドレス</td>
        <td>住所</td>
        <td>支援日</td>
        <td>支援金額</td>
        <td>支援パターン</td>
        <td>支援コメント</td>
    </tr>
    <?php foreach ($backers as $b): ?>
        <tr>
            <td>
                <?php echo h($b['BackedProject']['status']) ?>
            </td>
            <td>
                <?php
                if ($b['BackedProject']['manual_flag']) {
                    echo '手動入金';
                } else if ($b['BackedProject']['bank_flag']) {
                    echo '銀行振込';
                } else {
                    echo 'カード決済';
                }
                ?>
            </td>
            <td>
                <?php echo h($b['BackedProject']['stripe_charge_id']) ?>
            </td>
            <td>
                <?php if ($b['BackedProject']['bank_flag']): ?>
                    <?= $this->Form->create('BackedProject', [
                        'url' => [
                            'controller' => 'admin_projects',
                            'action' => 'change_bank_paid_status',
                            $b['BackedProject']['id']
                        ]
                    ]) ?>
                    <?= $this->Form->hidden('id', ['value' => $b['BackedProject']['id']]) ?>
                    <?= $this->Form->input('bank_paid_flag', [
                        'type' => 'select',
                        'label' => false,
                        'options' => [
                            0 => '未',
                            1 => '済'
                        ],
                        'value' => $b['BackedProject']['bank_paid_flag']
                    ]) ?>
                    <?= $this->Form->submit('変更', ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= $this->Form->end() ?>
                <?php endif; ?>
            </td>
            <td>
                <?php echo h($b['User']['nick_name']) ?>
            </td>
            <td>
                <?php echo h($b['User']['name']) ?>
            </td>
            <td>
                <?php echo h($b['User']['email']) ?>
            </td>
            <td>
                <?php echo h($b['User']['receive_address']) ?>
            </td>
            <td>
                <?php echo date('Y/m/d', strtotime(h($b['BackedProject']['created']))) ?>
            </td>
            <td>
                <?php echo number_format(h($b['BackedProject']['invest_amount'])) ?>円
            </td>
            <td>
                <?php echo h($b['BackingLevel']['name']) ?>
            </td>
            <td>
                <?php echo h($b['BackedProject']['comment']) ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<div class="container">
    <?php echo $this->element('base/pagination') ?>
</div>

