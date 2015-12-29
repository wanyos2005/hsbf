<?php
/* @var $this ContributionsByMembersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contributions By Members',
);

$this->menu=array(
	array('label'=>'Create ContributionsByMembers', 'url'=>array('create')),
	array('label'=>'Manage ContributionsByMembers', 'url'=>array('admin')),
);
?>

<h1>Contributions By Members</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
