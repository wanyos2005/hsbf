<?php
/* @var $this LoanApplicationsController */
/* @var $model LoanApplications */

$this->breadcrumbs=array(
	'Loan Applications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LoanApplications', 'url'=>array('index')),
	array('label'=>'Create LoanApplications', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#loan-applications-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Loan Applications</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'loan-applications-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'member',
		'loan_type',
		'amout_borrowed',
		'repayment_period',
		'witness',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
