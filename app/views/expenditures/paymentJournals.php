<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	'PaymentJournals',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form1', array('since'=>$others['since'], 'till' => $others['till'], 'type' =>  $others['type'], 'user' => $user)); ?>