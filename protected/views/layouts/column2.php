<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="span3 pull-left">
        <div id="sidebar-left">
            <?php $this->widget('UserCabinet'); ?>
        </div><!-- sidebar left -->
    </div>
    <div class="span2 pull-right">
        <div id="sidebar-right">
            <?php $this->widget('UserMenu'); ?>
        </div><!-- sidebar right -->
    </div>
    <div class="span7">
        <div id="content">
            <?php $this->widget('UserAlerts'); ?>           
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
<?php $this->endContent(); ?>