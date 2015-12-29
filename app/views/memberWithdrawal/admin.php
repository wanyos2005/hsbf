<?php
/* @var $this MemberWithdrawalController */
/* @var $model MemberWithdrawal */

$this->breadcrumbs=array(
	'Member Withdrawals'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MemberWithdrawal', 'url'=>array('index')),
	array('label'=>'Create MemberWithdrawal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#member-withdrawal-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Member Withdrawals</h1>

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
	'id'=>'member-withdrawal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'member',
		'status',
		'forwarded_by_secretary',
		'forwarded_by_treasurer',
		'approved_by_chairman',
		/*
		'secretary_date',
		'treasurer_date',
		'chairman_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
