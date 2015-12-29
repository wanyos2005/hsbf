<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	'balanceSheet',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('application.views.incomes._form2', array('since'=>$others['since'], 'till' => $others['till'], 'user' => $user)); ?>