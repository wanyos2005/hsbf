<?php
/* @var $this DependentMembersController */
/* @var $model DependentMembers */

$this->breadcrumbs=array(
	'Dependent Members'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List DependentMembers', 'url'=>array('index')),
	array('label'=>'Create DependentMembers', 'url'=>array('create')),
	array('label'=>'Update DependentMembers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DependentMembers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DependentMembers', 'url'=>array('admin')),
);
?>

<h1>View DependentMembers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'principal_member',
		'name',
		'idno',
		'alive',
		'relationship',
		'mobileno',
		'postaladdress',
	),
)); ?>
