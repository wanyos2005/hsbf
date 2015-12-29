<?php
/* @var $this IncomesController */
/* @var $model Incomes */

$this->breadcrumbs=array(
	'Incomes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Incomes', 'url'=>array('index')),
	array('label'=>'Create Incomes', 'url'=>array('create')),
	array('label'=>'Update Incomes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Incomes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Incomes', 'url'=>array('admin')),
);
?>

<h1>View Incomes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'votehead',
		'date',
		'amount',
		'member',
		'description',
	),
)); ?>
