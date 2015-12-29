<?php
/* @var $this CashWithdrawalsController */
/* @var $model CashWithdrawals */

$this->breadcrumbs=array(
	'Cash Withdrawals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashWithdrawals', 'url'=>array('index')),
	array('label'=>'Create CashWithdrawals', 'url'=>array('create')),
	array('label'=>'Update CashWithdrawals', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashWithdrawals', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashWithdrawals', 'url'=>array('admin')),
);
?>

<h1>View CashWithdrawals #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member',
		'cash_or_cheque',
		'cheque_no',
		'amount',
		'date',
		'received_by_secretary',
		'secretary_date',
		'approved_by_chairman',
		'chairman_date',
		'effected_by_treasurer',
		'treasurer_date',
	),
)); ?>
