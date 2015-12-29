<?php
/* @var $this IncomesController */
/* @var $model Incomes */

$this->breadcrumbs=array(
	'Incomes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Incomes', 'url'=>array('index')),
	array('label'=>'Create Incomes', 'url'=>array('create')),
	array('label'=>'View Incomes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Incomes', 'url'=>array('admin')),
);
?>

<h1>Update Incomes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>