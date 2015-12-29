<div class="sidebar sidebar-fixed<?php echo $this->sidebar_collapsed ? ' menu-min' : '' ?>" id="sidebar">
    <?php if (empty($_REQUEST['active']) || (isset($_REQUEST['active']) && $_REQUEST['active'] != 'rura')): ?>
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <a class="btn btn-success" href="<?php echo Yii::app()->createUrl('parking/default/index') ?>" title="Parking"><i class="icon-truck"></i></a>
                <a class="btn btn-warning" href="<?php echo Yii::app()->createUrl('users/default/view') ?>" title="Profile"><i class="icon-user"></i></a>
                <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('settings/default/index') ?>" title="Settings"><i class="icon-wrench"></i></a>
            </div>
            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>
                <span class="btn btn-info"></span>
                <span class="btn btn-warning"></span>
                <span class="btn btn-danger"></span>
            </div>
        </div><!-- #sidebar-shortcuts -->

        <ul class="nav nav-list my-nav">
            <li><a href="<?php echo Yii::app()->createUrl('admin/default/index') ?>"><i class="icon-dashboard"></i><span class="menu-text"> <?php echo Lang::t('Dashboard') ?> </span></a></li>

            <?php
            $this->renderPartial('application.views.contributionsByMembers._sideLinks');

            $officio = Maofficio::model()->officio();
            if (!empty($officio))
                $this->renderPartial('application.modules.users.views.default._sideLinks');
            ?>
        </ul><!-- /.nav-list -->

        <div class="sidebar-collapse" id="sidebar-collapse">
            <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
        </div>
    <?php endif; ?>
</div>