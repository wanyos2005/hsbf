<?php
/* @var $this MaofficioController */
/* @var $model Maofficio */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maofficio-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textField($model,'post'); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'member'); ?>
		<?php echo $form->textField($model,'member'); ?>
		<?php echo $form->error($model,'member'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'since'); ?>
		<?php echo $form->textField($model,'since'); ?>
		<?php echo $form->error($model,'since'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'till'); ?>
		<?php echo $form->textField($model,'till'); ?>
		<?php echo $form->error($model,'till'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->