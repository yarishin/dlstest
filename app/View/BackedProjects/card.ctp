<?php echo $this->Html->css('pay', null, ['inline' => false]) ?>
<?php $this->start('script') ?>
<script src="https://js.stripe.com/v3/"></script>
<?php $this->end() ?>
<?php echo $this->Html->script('pay', ['inline' => false]) ?>

<?php echo $this->element('pay/pay_header') ?>

<div class="pay clearfix">

    <div class="pay_content">
        <h3>
            支援内容を確認して、支援を確定してください！
        </h3>

        <div class="col-md-5">
            <h4>支援金額</h4>
            <div class="confirm_box">
			<span style="font-size:20px; font-weight:bold;">
				<?php echo number_format(h($backed_project['amount'])) ?> 円
			</span>
            </div>

            <h4>支援コメント</h4>
            <div class="confirm_box">
                <?php echo !empty($backed_project['comment']) ? nl2br(h($backed_project['comment'])) : '入力なし' ?>
            </div>
            <hr>

            <h4>リターン内容</h4>
            <div class="pay_return">
                <?php echo nl2br($backing_level['BackingLevel']['return_amount']); ?>
            </div>
            <br>
        </div>

        <div class="col-md-7">
            <h3><span class="el-icon-credit-card"></span> クレジットカード情報入力</h3>
            <div id="card">
                <form action="<?php echo $this->Html->url('/backed_projects/card') ?>" method="post" id="payment-form">
                    <label>
                        カード番号、有効期限（月/年）、CVCの３点をご入力ください。
                        （CVCは、カードの裏面に記載されている確認コードです。）
                    </label>
                    <div class="form-row form-group" style="margin-top: 15px;">
                        <div id="card-element"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary">支援を確定する(クレジットカード)</button>
                    </div>
                    <input type="hidden" name="token" id="token">
                </form>
            </div>

            <br><br>
            <h3>銀行振込でお支払い</h3>
            <div id="bank">
                <form action="<?php echo $this->Html->url('/backed_projects/bank') ?>" method="post" id="bank-form">
                    <label>
                        銀行振込でお支払をご希望の場合は、下記ボタンをクリックすることで、支援（ご購入）が確定されます。
                    </label>
                    <div class="form-group" style="margin-top: 15px;">
                        <button class="btn btn-lg btn-primary">支援を確定する（銀行振込）</button>
                    </div>
                    <input type="hidden" name="token" id="token">
                </form>
            </div>
        </div>
        <div id="stripe_pub_key" style="display:none;"><?php echo $this->Setting->stripe_pub_key($setting) ?></div>
    </div>
</div>
