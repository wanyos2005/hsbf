<?php
/* @var $this CashWithdrawalsController */
/* @var $model CashWithdrawals */

$this->breadcrumbs=array(
	'Cash Withdrawals'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CashWithdrawals', 'url'=>array('index')),
	array('label'=>'Create CashWithdrawals', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cash-withdrawals-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cash Withdrawals</h1>

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
	'id'=>'cash-withdrawals-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'member',
		'cash_or_cheque',
		'cheque_no',
		'amount',
		'date',
		/*
		'received_by_secretary',
		'secretary_date',
		'approved_by_chairman',
		'chairman_date',
		'effected_by_treasurer',
		'treasurer_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
