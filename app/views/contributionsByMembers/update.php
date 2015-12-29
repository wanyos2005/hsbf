<?php
/* @var $this ContributionsByMembersController */
/* @var $model ContributionsByMembers */

$this->breadcrumbs=array(
	'Contributions By Members'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContributionsByMembers', 'url'=>array('index')),
	array('label'=>'Create ContributionsByMembers', 'url'=>array('create')),
	array('label'=>'View ContributionsByMembers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ContributionsByMembers', 'url'=>array('admin')),
);
?>

<h1>Update ContributionsByMembers <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>