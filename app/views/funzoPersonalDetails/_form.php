<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'funzo-personal-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'APP_ID'); ?>
		<?php echo $form->textField($model,'APP_ID'); ?>
		<?php echo $form->error($model,'APP_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MIDDLE_NAME'); ?>
		<?php echo $form->textField($model,'MIDDLE_NAME',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'MIDDLE_NAME'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'LAST_NAME'); ?>
		<?php echo $form->textField($model,'LAST_NAME',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'LAST_NAME'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FAST_NAME'); ?>
		<?php echo $form->textField($model,'FAST_NAME',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'FAST_NAME'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IDno'); ?>
		<?php echo $form->textField($model,'IDno',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'IDno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PINNO'); ?>
		<?php echo $form->textField($model,'PINNO',array('size'=>48,'maxlength'=>48)); ?>
		<?php echo $form->error($model,'PINNO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DOB'); ?>
		<?php echo $form->textField($model,'DOB',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'DOB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GENDER'); ?>
		<?php echo $form->textField($model,'GENDER',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'GENDER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'EMAIL'); ?>
		<?php echo $form->textField($model,'EMAIL',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'EMAIL'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IMPAIRED_IDFK'); ?>
		<?php echo $form->textField($model,'IMPAIRED_IDFK',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'IMPAIRED_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TEL_'); ?>
		<?php echo $form->textField($model,'TEL_',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'TEL_'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BOX_NO'); ?>
		<?php echo $form->textField($model,'BOX_NO',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'BOX_NO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'POSTAL_CODE'); ?>
		<?php echo $form->textField($model,'POSTAL_CODE',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'POSTAL_CODE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TOWN'); ?>
		<?php echo $form->textField($model,'TOWN',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'TOWN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'LOCATION'); ?>
		<?php echo $form->textField($model,'LOCATION',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'LOCATION'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DIVISION'); ?>
		<?php echo $form->textField($model,'DIVISION',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'DIVISION'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DISTRICT_IDFK'); ?>
		<?php echo $form->textField($model,'DISTRICT_IDFK'); ?>
		<?php echo $form->error($model,'DISTRICT_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'APPLICATION_TYPE'); ?>
		<?php echo $form->textField($model,'APPLICATION_TYPE'); ?>
		<?php echo $form->error($model,'APPLICATION_TYPE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SERIAL_NO'); ?>
		<?php echo $form->textField($model,'SERIAL_NO',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'SERIAL_NO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'EMPLOYED'); ?>
		<?php echo $form->textField($model,'EMPLOYED',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'EMPLOYED'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CONSTITUENCY_IDFK'); ?>
		<?php echo $form->textField($model,'CONSTITUENCY_IDFK'); ?>
		<?php echo $form->error($model,'CONSTITUENCY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FORM_PRINT'); ?>
		<?php echo $form->textField($model,'FORM_PRINT'); ?>
		<?php echo $form->error($model,'FORM_PRINT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DATE_POSTED'); ?>
		<?php echo $form->textField($model,'DATE_POSTED',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'DATE_POSTED'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'COUNTY_IDFK'); ?>
		<?php echo $form->textField($model,'COUNTY_IDFK'); ?>
		<?php echo $form->error($model,'COUNTY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'M_STATUS'); ?>
		<?php echo $form->textField($model,'M_STATUS'); ?>
		<?php echo $form->error($model,'M_STATUS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SPOUSE_NAME'); ?>
		<?php echo $form->textField($model,'SPOUSE_NAME',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'SPOUSE_NAME'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CURR_COUNTY_IDFK'); ?>
		<?php echo $form->textField($model,'CURR_COUNTY_IDFK'); ?>
		<?php echo $form->error($model,'CURR_COUNTY_IDFK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CATEGORY'); ?>
		<?php echo $form->textField($model,'CATEGORY',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CATEGORY'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'LOAN_TYPE'); ?>
		<?php echo $form->textField($model,'LOAN_TYPE',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'LOAN_TYPE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SERVICE_TYPE'); ?>
		<?php echo $form->textField($model,'SERVICE_TYPE',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'SERVICE_TYPE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DOB_D'); ?>
		<?php echo $form->textField($model,'DOB_D',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'DOB_D'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DOB_M'); ?>
		<?php echo $form->textField($model,'DOB_M',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'DOB_M'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DOB_Y'); ?>
		<?php echo $form->textField($model,'DOB_Y',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'DOB_Y'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->