<?php
/* @var $this LoanApplicationsController */
/* @var $model LoanApplications */

$this->breadcrumbs=array(
	'Loan Applications'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LoanApplications', 'url'=>array('index')),
	array('label'=>'Create LoanApplications', 'url'=>array('create')),
	array('label'=>'Update LoanApplications', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LoanApplications', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LoanApplications', 'url'=>array('admin')),
);
?>

<h1>View LoanApplications #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member',
		'loan_type',
		'amout_borrowed',
		'repayment_period',
		'witness',
		'guarantor1',
		'guarantor2',
		'witness_date',
		'guarantor1_date',
		'guarantor2_date',
		'forwarded_by_secretary',
		'secretary_date',
		'forwarded_by_treasurer',
		'treasurer_date',
		'approved_by_chairman',
		'chairman_date',
		'present_net_pay',
		'net_pay_after_loan_repayment',
	),
)); ?>
