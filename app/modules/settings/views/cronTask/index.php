<?php

$this->breadcrumbs = array(
    Lang::t(ucfirst($this->getModuleName())) => array('default/index'),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_grid', array('model' => $model)); ?>