<?php
/* @var $this MaofficioController */
/* @var $model Maofficio */

$this->breadcrumbs=array(
	'Maofficios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Maofficio', 'url'=>array('index')),
	array('label'=>'Create Maofficio', 'url'=>array('create')),
	array('label'=>'View Maofficio', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Maofficio', 'url'=>array('admin')),
);
?>

<h1>Update Maofficio <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>