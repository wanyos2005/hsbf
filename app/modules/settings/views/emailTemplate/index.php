<?php
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>
<div class="widget-box transparent">
        <div class="widget-header">
                <?php echo $this->renderPartial('settings.views.emailTemplate._tab') ?>
        </div>
        <div class="widget-body widget-body-style2">
                <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                                <?php $this->renderPartial('_grid', array('model' => $model)); ?>
                        </div>
                </div>
        </div>
</div>