<?php
/* @var $this VoteheadsController */
/* @var $model Voteheads */

$this->breadcrumbs=array(
	'Voteheads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Voteheads', 'url'=>array('index')),
	array('label'=>'Create Voteheads', 'url'=>array('create')),
	array('label'=>'View Voteheads', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Voteheads', 'url'=>array('admin')),
);
?>

<h1>Update Voteheads <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>