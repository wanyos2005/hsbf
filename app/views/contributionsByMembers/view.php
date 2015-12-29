<?php
/* @var $this ContributionsByMembersController */
/* @var $model ContributionsByMembers */

$this->breadcrumbs=array(
	'Contributions By Members'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ContributionsByMembers', 'url'=>array('index')),
	array('label'=>'Create ContributionsByMembers', 'url'=>array('create')),
	array('label'=>'Update ContributionsByMembers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ContributionsByMembers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContributionsByMembers', 'url'=>array('admin')),
);
?>

<h1>View ContributionsByMembers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member',
		'contribution_type',
		'amount',
		'date',
		'receiptno',
	),
)); ?>
