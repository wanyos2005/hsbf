<?php
$this->breadcrumbs = array(
    Lang::t($this->resourceLabel) => array('index'),
    $this->pageTitle,
);
?>
<div class="row">
        <div class="col-lg-12">
                <div class="widget-box">
                        <div class="widget-header">
                                <h4><?php echo CHtml::encode($this->pageTitle); ?></h4>
                                <div class="widget-toolbar">
                                        <a href="<?php echo $this->createUrl('index') ?>"><i class="icon-remove"></i> <?php echo Lang::t('Cancel') ?></a>
                                </div>
                        </div>
                        <div class="widget-body">
                                <div class="widget-main">
                                        <?php $this->renderPartial('_form', array('model' => $model)); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>