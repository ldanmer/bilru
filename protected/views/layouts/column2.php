<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="span3 pull-left" id="sidebar-left">
        <?php $this->widget('UserCabinet'); ?>
    </div>
    <div class="span3 pull-right" id="sidebar-right">
        <?php $this->widget('UserMenu'); ?>
    </div>
    <div class="span7">
        <div id="content">
            <?php $this->widget('UserAlerts'); ?>           
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
<?php $this->endContent(); ?>