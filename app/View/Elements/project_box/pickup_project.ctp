<div class="pickup_project clearfix">
    <div class="imgholder">
        <?php if($this->Label->url_thumb($project['Project']['pic'], 400, 267)): ?>
            <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                <?php echo $this->Label->image_thumb($project['Project']['pic'], 400, 267, array('class' => 'img img-responsive')) ?>
            </a>
        <?php endif; ?>
        <?php if($this->Project->get_backed_per($project) >= 100): ?>
            <div class="project_success"> SUCCESS!</div>
        <?php endif ?>
    </div>
    <div class="right">
        <h2 class="title">
            <?php if($project['Project']['opened'] == 'yes'): ?>
                <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                    <?php echo h($project['Project']['project_name']); ?>
                    - <?php echo h($setting['site_name']) ?>
                </a>
            <?php else: ?>
                <?php echo h($project['Project']['project_name']); ?>
            <?php endif ?>
        </h2>
        <p class="description">
            <?php echo $this->Text->truncate(h($project['Project']['description']), 90, array('html' => false)); ?>
        </p>

        <div class="graph_footer">
            <?php echo $this->element('project/graph', array('project' => $project)) ?>

            <div class="grid_footer clearfix">
                <div>
                    ¥<?php echo number_format(h($project['Project']['collected_amount'])); ?>
                </div>
                <div>
                    <span class="el-icon-group"></span>
                    <?php echo h($project['Project']['backers']); ?>人
                </div>
                <div>
                    <span class="el-icon-time"></span>
                    <?php echo $this->Project->get_zan_day($project); ?>
                </div>
            </div>
        </div>
    </div>

</div>
