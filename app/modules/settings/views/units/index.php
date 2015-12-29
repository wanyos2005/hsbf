<?php
$this->breadcrumbs = array(
    Lang::t('Settings') => array('default/index'),
    $this->pageTitle,
);
?>
<div class="row">
        <div class="col-lg-6">
                <?php $this->renderPartial('_grid', array('model' => $model)); ?>
        </div>
        <div class="col-lg-6">
                <?php $this->renderPartial('conversion/_grid', array('model' => $conversionModel)); ?>
        </div>
</div>
