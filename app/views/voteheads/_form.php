<?php
/* @var $this VoteheadsController */
/* @var $model Voteheads */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'voteheads-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'votehead'); ?>
		<?php echo $form->textField($model,'votehead',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'votehead'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'incomeOrExpense'); ?>
		<?php echo $form->textField($model,'incomeOrExpense',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'incomeOrExpense'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->