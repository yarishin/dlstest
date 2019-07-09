</div>
<div id="back_top" onclick="back_top();">
    <?php echo $this->Html->image('back_top.png') ?>
</div>
<div class="footer footer_pc hidden-xs">
    <div class="menu clearfix">
        <?php echo $this->Html->link('お問い合わせ', '/contact') ?>　｜　
        <?php echo $this->Html->link('利用規約', '/rule') ?>　｜　
        <?php echo $this->Html->link('特定商取引法に基づく表記', '/tokutei') ?>　｜　
        <?php echo $this->Html->link('プライバシーポリシー', '/policy') ?>　｜　
        <?php echo $this->Html->link('運営会社', h($setting['company_url']), array('target' => '_blank')) ?>
    </div>
<?php
echo <<<EOM
<script>
var _CIDN = "cid";
var _PMTN = "p";
var _param = location.search.substring(1).split("&");
var _ulp = "", _ulcid = "";
for(var i = 0; _param[i]; i++){ var kv = _param[i].split("="); if(kv[0] == _PMTN && kv[1].length > 1){ _ulp = kv[1]; } if(kv[0] == _CIDN && kv[1].length > 1){ _ulcid = kv[1]; }}
if(_ulp && _ulcid){ document.cookie = "CL_" + _ulp + "=" + decodeURIComponent(_ulcid) + "; expires=" + new Date(new Date().getTime() + (43200 * 1000)).toUTCString() + "; path=/;"; }
</script>
EOM;
?>
    <div class="copyright">
        © 2014 <?php echo h($setting['copy_right']) ?>
    </div>
</div>
<div class="footer footer_sp visible-xs">
    <div class="btn_sp" onclick="footer_menu();">
        <span class="el-icon-lines"></span>
    </div>
    <div class="menu_sp">
        <div onclick="location.href='<?php echo $this->Html->url('/contact') ?>'">
            お問い合わせ
        </div>
        <div onclick="location.href='<?php echo $this->Html->url('/rule') ?>'">
            利用規約
        </div>
        <div onclick="location.href='<?php echo $this->Html->url('/tokutei') ?>'">
            特定商取引法
        </div>
        <div onclick="location.href='<?php echo $this->Html->url('/policy') ?>'">
            プライバシーポリシー
        </div>
        <div onclick="window.open('<?php echo $this->Html->url(h($setting['company_url'])) ?>', '_blank');">
            運営会社
        </div>
        <div>
            © 2014 <?php echo h($setting['copy_right']) ?>
        </div>
    </div>
</div>
</div>

<div id="loader" style="display: none;">
    <div id="loader_content">
        <?php echo $this->Html->image('loader.gif') ?>
    </div>
</div>

<?php echo $this->Html->script('jquery-2.1.0.min') ?>
<?php echo $this->Html->script('/bootstrap/js/bootstrap.min') ?>
<?php //echo $this->Html->script('anime') ?>
<?php echo $this->element('js/default_js') ?>
<?php echo $this->Html->script('default') ?>
<?php echo $this->fetch('script') ?>

</body>
</html>
