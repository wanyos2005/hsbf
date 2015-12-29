<?php
/* @var $this KinsAndNomineesController */
/* @var $model KinsAndNominees */

$this->breadcrumbs=array(
	'Kins And Nominees'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List KinsAndNominees', 'url'=>array('index')),
	array('label'=>'Create KinsAndNominees', 'url'=>array('create')),
	array('label'=>'Update KinsAndNominees', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete KinsAndNominees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KinsAndNominees', 'url'=>array('admin')),
);
?>

<h1>View KinsAndNominees #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'dependent_member',
		'kinOrNominee',
		'percent',
		'active',
	),
)); ?>
