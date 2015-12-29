<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */

$this->breadcrumbs=array(
	'Funzo Personal Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FunzoPersonalDetails', 'url'=>array('index')),
	array('label'=>'Manage FunzoPersonalDetails', 'url'=>array('admin')),
);
?>

<h1>Create FunzoPersonalDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>