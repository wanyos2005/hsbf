<?php
/* @var $this MemberWithdrawalController */
/* @var $model MemberWithdrawal */

$this->breadcrumbs=array(
	'Member Withdrawals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MemberWithdrawal', 'url'=>array('index')),
	array('label'=>'Create MemberWithdrawal', 'url'=>array('create')),
	array('label'=>'Update MemberWithdrawal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MemberWithdrawal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MemberWithdrawal', 'url'=>array('admin')),
);
?>

<h1>View MemberWithdrawal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member',
		'status',
		'forwarded_by_secretary',
		'forwarded_by_treasurer',
		'approved_by_chairman',
		'secretary_date',
		'treasurer_date',
		'chairman_date',
	),
)); ?>
