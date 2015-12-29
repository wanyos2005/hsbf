<?php
/* @var $this CashWithdrawalsController */
/* @var $model CashWithdrawals */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'member'); ?>
		<?php echo $form->textField($model,'member',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cash_or_cheque'); ?>
		<?php echo $form->textField($model,'cash_or_cheque',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cheque_no'); ?>
		<?php echo $form->textField($model,'cheque_no',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'received_by_secretary'); ?>
		<?php echo $form->textField($model,'received_by_secretary',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'secretary_date'); ?>
		<?php echo $form->textField($model,'secretary_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_by_chairman'); ?>
		<?php echo $form->textField($model,'approved_by_chairman',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chairman_date'); ?>
		<?php echo $form->textField($model,'chairman_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'effected_by_treasurer'); ?>
		<?php echo $form->textField($model,'effected_by_treasurer',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'treasurer_date'); ?>
		<?php echo $form->textField($model,'treasurer_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->