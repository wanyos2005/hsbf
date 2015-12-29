<?php
/* @var $this VoteheadsController */
/* @var $model Voteheads */

$this->breadcrumbs=array(
	'Voteheads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Voteheads', 'url'=>array('index')),
	array('label'=>'Manage Voteheads', 'url'=>array('admin')),
);
?>

<h1>Create Voteheads</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>