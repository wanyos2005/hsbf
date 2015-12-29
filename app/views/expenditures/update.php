<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Create Expenditures', 'url'=>array('create')),
	array('label'=>'View Expenditures', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<h1>Update Expenditures <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>