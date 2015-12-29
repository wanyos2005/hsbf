<?php
/* @var $this VoteheadsController */
/* @var $model Voteheads */

$this->breadcrumbs=array(
	'Voteheads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Voteheads', 'url'=>array('index')),
	array('label'=>'Create Voteheads', 'url'=>array('create')),
	array('label'=>'Update Voteheads', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Voteheads', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Voteheads', 'url'=>array('admin')),
);
?>

<h1>View Voteheads #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'votehead',
		'incomeOrExpense',
	),
)); ?>
