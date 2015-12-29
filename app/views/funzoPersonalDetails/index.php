<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Funzo Personal Details',
);

$this->menu=array(
	array('label'=>'Create FunzoPersonalDetails', 'url'=>array('create')),
	array('label'=>'Manage FunzoPersonalDetails', 'url'=>array('admin')),
);
?>

<h1>Funzo Personal Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
