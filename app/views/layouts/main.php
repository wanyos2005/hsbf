<!DOCTYPE html>
<html lang="en">
    <?php echo $this->renderPartial('application.views.layouts.partials._head') ?>
    <body class="navbar-fixed skin-1 breadcrumbs-fixed">
        <?php $this->renderPartial('application.views.layouts.partials._topbar') ?>
        <div class="main-container" id="main-container">
            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#"><span class="menu-text"></span></a>
                <?php
                //if (Yii::app()->user->getState(UserIdentity::STATE_USER_LEVEL) === UserLevels::LEVEL_MEMBER)
                //$this->renderPartial('application.views.layouts.partials._sideNav');
                //else
                $this->renderPartial('application.views.layouts.partials._sideNav');
                ?>
                <div class="main-content">
                    <?php $this->renderPartial('application.views.layouts.partials._breadcrumbs') ?>
                    <div class="page-content">
                        <?php if ($this->showPageTitle): ?>
                            <div class="page-header">
                                <h1><?php echo CHtml::encode($this->pageTitle) ?>
                                    <?php if (!empty($this->pageDescription)): ?><small><i class="icon-double-angle-right"></i> <?php echo CHtml::encode($this->pageDescription) ?></small><?php endif; ?>
                                </h1>
                            </div><!--/.page-header-->
                        <?php endif; ?>
                        <?php $this->renderPartial('application.views.widgets._alert') ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <?php echo $content; ?>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!--/.col-->
                        </div><!--/.row-->
                    </div><!--/.page-content-->
                </div><!--/.main-content -->
                <div class="ace-settings-container hidden" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="default" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>
                    </div>
                </div><!-- /#ace-settings-container -->
            </div><!--/.main-container-inner-->
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div><!--/.main-container-->
    </body>
</html>