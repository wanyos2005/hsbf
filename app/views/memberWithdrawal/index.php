<?php
/* @var $this MemberWithdrawalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Member Withdrawals',
);

$this->menu=array(
	array('label'=>'Create MemberWithdrawal', 'url'=>array('create')),
	array('label'=>'Manage MemberWithdrawal', 'url'=>array('admin')),
);
?>

<h1>Member Withdrawals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
