<?php
/* @var $this IncomesController */
/* @var $model Incomes */

$this->breadcrumbs=array(
	'Incomes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Incomes', 'url'=>array('index')),
	array('label'=>'Manage Incomes', 'url'=>array('admin')),
);
?>

<h1>Create Incomes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>