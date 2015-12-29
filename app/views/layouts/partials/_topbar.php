<div class="navbar navbar-default navbar-fixed-top" id="navbar">
        <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                        <a href="<?php echo $this->home_url ?>" class="navbar-brand">
                                <small><?php echo CHtml::encode($this->settings[Constants::KEY_SITE_NAME]); ?></small>
                        </a><!-- /.brand -->
                </div><!-- /.navbar-header -->
                <div class="navbar-header pull-right" role="navigation">
                        <ul class="nav ace-nav">
                                <?php //$this->renderPartial('admin.views.layouts.partials._topbar_notifications') ?>
                                <?php $this->renderPartial('msg.views.layouts._topbar_messages') ?>
                                <?php $this->renderPartial('application.views.layouts.partials._topbar_usermenu') ?>
                        </ul><!-- /.ace-nav -->
                </div><!-- /.navbar-header -->
        </div><!-- /.container -->
</div>