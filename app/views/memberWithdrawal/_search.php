<?php
/* @var $this MemberWithdrawalController */
/* @var $model MemberWithdrawal */
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
		<?php echo $form->textField($model,'member'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forwarded_by_secretary'); ?>
		<?php echo $form->textField($model,'forwarded_by_secretary',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forwarded_by_treasurer'); ?>
		<?php echo $form->textField($model,'forwarded_by_treasurer',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_by_chairman'); ?>
		<?php echo $form->textField($model,'approved_by_chairman',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'secretary_date'); ?>
		<?php echo $form->textField($model,'secretary_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'treasurer_date'); ?>
		<?php echo $form->textField($model,'treasurer_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chairman_date'); ?>
		<?php echo $form->textField($model,'chairman_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->