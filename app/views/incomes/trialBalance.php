<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	'trialBalance',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('application.views.incomes._form3', array('till' => $others['till'], 'user' => $user)); ?>