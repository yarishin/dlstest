<?php $this->start('ogp') ?>
<meta property="og:title" content="<?php echo h($setting['site_title']) ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo $this->Html->url('/', true) ?>"/>
<meta property="og:image"
      content="<?php echo ($this->Label->link($setting['facebook_img'])) ? $this->Label->url($setting['facebook_img'], true) : '' ?>"/>
<meta property="og:site_name" content="<?php echo h($setting['site_name']) ?>"/>
<meta property="og:description" content="<?php echo h($setting['site_description']) ?>"/>
<?php $this->end() ?>

<?php echo $this->Html->css('top', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid_report', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<?php if($smart_phone): ?>
    <?php echo $this->Html->css('sp/grid_sp', null, array('inline' => false)) ?>
<?php endif ?>

<div class="toppage">
    <div class="top_box">
        <div class="content1">
            <?php $this->Setting->display_content($setting, 1); ?>
        </div>
        <?php if($setting['top_box_content_num'] == 2): ?>
            <div class="content2">
                <?php $this->Setting->display_content($setting, 2); ?>
            </div>
        <?php endif ?>
    </div>

    <?php if(!empty($pickup_pj)): ?>
        <div class="pickup_project_box">
            <h3 class="pickup"><span class="el-icon-smiley"></span> 新着ピックアップ</h3>
            <?php echo $this->element('project_box/pickup_project', array('project' => $pickup_pj)) ?>
        </div>
    <?php endif; ?>

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


    <h3 class="pickup"><span class="el-icon-th"></span> スタッフオススメ</h3>
     <div id="grid_container" class="clearfix">
        <?php foreach($projects as $idx => $project): ?>
       <?php if(isset($project['Project'])): ?>
                <?php echo $this->element('project_box/project_box_for_normal', compact('project')) ?>
            <?php endif; ?>
        <?php endforeach; ?>
   </div>

    <?php if(!empty($reports)): ?>
        <div class="reports">
            <h3 class="report"><span class="el-icon-bullhorn"></span> 活動報告</h3>

            <div id="grid_container_report" class="clearfix">
                <?php foreach($reports as $report): ?>
                    <div class="grid_wrap_report">
                        <?php echo $this->element('report_box/report_box_opened', array('report' => $report)) ?>
                       </div>
                <?php endforeach; ?>
</div>
     </div>   
    <?php else: ?>
        <br><br>
    <?php endif; ?>

    <?php //echo $this->element('base/social_btn')?>
</div>

<?php $this->start('script') ?>
<script>
    $(document).ready(function () {
        top_box_position();
        grid_position();
        top_report_position();
    });

    function top_box_position() {
        <?php if($setting['top_box_content_num'] == 1):?>
        $('.content1').css('display', 'table-cell');
        $('.content1').css('padding-bottom', '0px');
        $('.content1').width('100%');
        <?php else:?>
        if ($(window).width() > 780) {
            $('.content1').css('display', 'table-cell');
            $('.content1').css('padding-bottom', '0px');
            $('.content2').css('display', 'table-cell');
            $('.content2').css('padding-top', '40px');
            $('.content2').css('padding-bottom', '0px');
            $('.content1').width('50%');
            $('.content2').width('50%');
        } else {
            $('.content1').css('display', 'block');
            $('.content1').css('padding-bottom', '0');
            $('.content2').css('display', 'block');
            $('.content2').css('padding-top', '10px');
            $('.content2').css('padding-bottom', '25px');
            $('.content1').width('100%');
            $('.content2').width('100%');
        }
        <?php endif?>

        resize_movie(350);
        resize_img();
    }

    function resize_img() {
        $('.top_box_img:visible').css('max-width', '95%');
        if ($('.top_box_img:visible').width() > 350) $('.top_box_img:visible').width(350);
    }
</script>
<?php $this->end() ?>
