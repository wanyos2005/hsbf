<?php
/* @var $this DependentMembersController */
/* @var $model DependentMembers */

$this->breadcrumbs=array(
	'Dependent Members'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DependentMembers', 'url'=>array('index')),
	array('label'=>'Create DependentMembers', 'url'=>array('create')),
	array('label'=>'View DependentMembers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DependentMembers', 'url'=>array('admin')),
);
?>

<h1>Update DependentMembers <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>