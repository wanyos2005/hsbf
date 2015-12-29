<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Create Expenditures', 'url'=>array('create')),
	array('label'=>'Update Expenditures', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Expenditures', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<h1>View Expenditures #<?php echo $model->id; ?></h1>

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
