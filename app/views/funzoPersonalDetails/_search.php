<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'APP_ID'); ?>
		<?php echo $form->textField($model,'APP_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MIDDLE_NAME'); ?>
		<?php echo $form->textField($model,'MIDDLE_NAME',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LAST_NAME'); ?>
		<?php echo $form->textField($model,'LAST_NAME',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FAST_NAME'); ?>
		<?php echo $form->textField($model,'FAST_NAME',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IDno'); ?>
		<?php echo $form->textField($model,'IDno',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PINNO'); ?>
		<?php echo $form->textField($model,'PINNO',array('size'=>48,'maxlength'=>48)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DOB'); ?>
		<?php echo $form->textField($model,'DOB',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GENDER'); ?>
		<?php echo $form->textField($model,'GENDER',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EMAIL'); ?>
		<?php echo $form->textField($model,'EMAIL',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IMPAIRED_IDFK'); ?>
		<?php echo $form->textField($model,'IMPAIRED_IDFK',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TEL_'); ?>
		<?php echo $form->textField($model,'TEL_',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BOX_NO'); ?>
		<?php echo $form->textField($model,'BOX_NO',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'POSTAL_CODE'); ?>
		<?php echo $form->textField($model,'POSTAL_CODE',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TOWN'); ?>
		<?php echo $form->textField($model,'TOWN',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LOCATION'); ?>
		<?php echo $form->textField($model,'LOCATION',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DIVISION'); ?>
		<?php echo $form->textField($model,'DIVISION',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DISTRICT_IDFK'); ?>
		<?php echo $form->textField($model,'DISTRICT_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'APPLICATION_TYPE'); ?>
		<?php echo $form->textField($model,'APPLICATION_TYPE'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SERIAL_NO'); ?>
		<?php echo $form->textField($model,'SERIAL_NO',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EMPLOYED'); ?>
		<?php echo $form->textField($model,'EMPLOYED',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CONSTITUENCY_IDFK'); ?>
		<?php echo $form->textField($model,'CONSTITUENCY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FORM_PRINT'); ?>
		<?php echo $form->textField($model,'FORM_PRINT'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_POSTED'); ?>
		<?php echo $form->textField($model,'DATE_POSTED',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COUNTY_IDFK'); ?>
		<?php echo $form->textField($model,'COUNTY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'M_STATUS'); ?>
		<?php echo $form->textField($model,'M_STATUS'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SPOUSE_NAME'); ?>
		<?php echo $form->textField($model,'SPOUSE_NAME',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CURR_COUNTY_IDFK'); ?>
		<?php echo $form->textField($model,'CURR_COUNTY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY'); ?>
		<?php echo $form->textField($model,'CATEGORY',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LOAN_TYPE'); ?>
		<?php echo $form->textField($model,'LOAN_TYPE',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SERVICE_TYPE'); ?>
		<?php echo $form->textField($model,'SERVICE_TYPE',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DOB_D'); ?>
		<?php echo $form->textField($model,'DOB_D',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DOB_M'); ?>
		<?php echo $form->textField($model,'DOB_M',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DOB_Y'); ?>
		<?php echo $form->textField($model,'DOB_Y',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->