<?php

$this->breadcrumbs = array(
    Lang::t(ucfirst($this->getModuleName())) => array('default/index'),
    Lang::t($this->resourceLabel . 's') => array('index'),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>