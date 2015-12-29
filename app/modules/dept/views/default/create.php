<?php

$this->breadcrumbs = array(
    Lang::t(Common::pluralize($this->resourceLabel)) => array('index'),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>