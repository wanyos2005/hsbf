<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	'ledgerBook',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('application.views.incomes._form4', array('member'=>$others['member'], 'since'=>$others['since'], 'till' => $others['till'], 'user' => $user)); ?>