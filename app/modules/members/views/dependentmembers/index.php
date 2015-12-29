<?php
/* @var $this DependentMembersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dependent Members',
);

$this->menu=array(
	array('label'=>'Create DependentMembers', 'url'=>array('create')),
	array('label'=>'Manage DependentMembers', 'url'=>array('admin')),
);
?>

<h1>Dependent Members</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>