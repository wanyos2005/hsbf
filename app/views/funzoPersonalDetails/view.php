<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */

$this->breadcrumbs=array(
	'Funzo Personal Details'=>array('index'),
	$model->APP_ID,
);

$this->menu=array(
	array('label'=>'List FunzoPersonalDetails', 'url'=>array('index')),
	array('label'=>'Create FunzoPersonalDetails', 'url'=>array('create')),
	array('label'=>'Update FunzoPersonalDetails', 'url'=>array('update', 'id'=>$model->APP_ID)),
	array('label'=>'Delete FunzoPersonalDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->APP_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FunzoPersonalDetails', 'url'=>array('admin')),
);
?>

<h1>View FunzoPersonalDetails #<?php echo $model->APP_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'APP_ID',
		'MIDDLE_NAME',
		'LAST_NAME',
		'FAST_NAME',
		'IDno',
		'PINNO',
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
	),
)); ?>
