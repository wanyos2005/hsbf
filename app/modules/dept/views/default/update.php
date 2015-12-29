<?php

$this->breadcrumbs = array(
    Lang::t(Common::pluralize($this->resourceLabel)) => array('index'),
    CHtml::encode($model->name) => array('view', 'id' => $model->id),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>