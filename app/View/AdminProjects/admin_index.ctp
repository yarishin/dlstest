<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<div class="bread">
    <?php echo $this->Html->link('プロジェクト', '/admin/admin_projects/') ?> &gt; プロジェクト一覧
</div>
<div class="setting_title">
    <h2>プロジェクト一覧</h2>
</div>

<table>
    <tr>
        <th>プロジェクト名</th><th>User_ID</th><th>name</th><th>email</th>
    </tr>
<?php
foreach($projects as $v){
        echo "<tr>\n";
        echo "<td>".$v['Project']['project_name']."</td>\n";
        echo "<td>".$v['User']['id']."</td>\n";
        echo "<td>".$v['User']['name']."</td>\n";
        echo "<td>".$v['User']['email']."</td>\n";
        echo "</tr>\n";
    }
?>
</table>

<?php echo $this->element('admin/setting_project_main_menu', array('mode' => 'index')) ?>

<div id="grid_container" class="clearfix">
    <?php foreach($projects as $project): ?>
        <?php echo $this->element('project_box/project_box_for_setting', array('project' => $project)) ?>
    <?php endforeach; ?>
</div>
<div class="container">
    <?php echo $this->element('base/pagination') ?>
</div>

<?php $this->start('script') ?>
<script>
    $(document).ready(function () {
        grid_position();
    });
    window.onresize = function () {
        grid_position();
        footer_position();
    };
</script>
<?php $this->end() ?>
