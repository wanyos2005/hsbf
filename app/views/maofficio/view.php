<?php
/* @var $this MaofficioController */
/* @var $model Maofficio */

$this->breadcrumbs=array(
	'Maofficios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Maofficio', 'url'=>array('index')),
	array('label'=>'Create Maofficio', 'url'=>array('create')),
	array('label'=>'Update Maofficio', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Maofficio', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Maofficio', 'url'=>array('admin')),
);
?>

<h1>View Maofficio #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'post',
		'member',
		'since',
		'till',
	),
)); ?>
