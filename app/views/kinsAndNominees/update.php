<?php
/* @var $this KinsAndNomineesController */
/* @var $model KinsAndNominees */

$this->breadcrumbs=array(
	'Kins And Nominees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List KinsAndNominees', 'url'=>array('index')),
	array('label'=>'Create KinsAndNominees', 'url'=>array('create')),
	array('label'=>'View KinsAndNominees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage KinsAndNominees', 'url'=>array('admin')),
);
?>

<h1>Update KinsAndNominees <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>