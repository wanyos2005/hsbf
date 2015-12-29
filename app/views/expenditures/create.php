<?php
/* @var $this ExpendituresController */
/* @var $model Expenditures */

$this->breadcrumbs=array(
	'Expenditures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Expenditures', 'url'=>array('index')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('income'=>$others[Voteheads::INCOME], 'expenditure' => $others[Voteheads::EXPENSE], 'user' => $user)); ?>