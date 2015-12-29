<?php

$this->breadcrumbs = array(
    Lang::t('Settings') => array('default/index'),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_grid', array('model' => $model)); ?>