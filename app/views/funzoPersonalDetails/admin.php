<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */

$this->breadcrumbs=array(
	'Funzo Personal Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FunzoPersonalDetails', 'url'=>array('index')),
	array('label'=>'Create FunzoPersonalDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#funzo-personal-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Funzo Personal Details</h1>

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
	'id'=>'funzo-personal-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'APP_ID',
		'MIDDLE_NAME',
		'LAST_NAME',
		'FAST_NAME',
		'IDno',
		'PINNO',
		/*
		'DOB',
		'GENDER',
		'EMAIL',
		'IMPAIRED_IDFK',
		'TEL_',
		'BOX_NO',
		'POSTAL_CODE',
		'TOWN',
		'LOCATION',
		'DIVISION',
		'DISTRICT_IDFK',
		'APPLICATION_TYPE',
		'SERIAL_NO',
		'EMPLOYED',
		'CONSTITUENCY_IDFK',
		'FORM_PRINT',
		'DATE_POSTED',
		'COUNTY_IDFK',
		'M_STATUS',
		'SPOUSE_NAME',
		'CURR_COUNTY_IDFK',
		'CATEGORY',
		'LOAN_TYPE',
		'SERVICE_TYPE',
		'DOB_D',
		'DOB_M',
		'DOB_Y',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
