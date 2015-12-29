<?php
/* @var $this LoanApplicationsController */
/* @var $model LoanApplications */
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
		<?php echo $form->label($model,'loan_type'); ?>
		<?php echo $form->textField($model,'loan_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amout_borrowed'); ?>
		<?php echo $form->textField($model,'amout_borrowed',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_period'); ?>
		<?php echo $form->textField($model,'repayment_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'witness'); ?>
		<?php echo $form->textField($model,'witness'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guarantor1'); ?>
		<?php echo $form->textField($model,'guarantor1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guarantor2'); ?>
		<?php echo $form->textField($model,'guarantor2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'witness_date'); ?>
		<?php echo $form->textField($model,'witness_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guarantor1_date'); ?>
		<?php echo $form->textField($model,'guarantor1_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guarantor2_date'); ?>
		<?php echo $form->textField($model,'guarantor2_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forwarded_by_secretary'); ?>
		<?php echo $form->textField($model,'forwarded_by_secretary',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'secretary_date'); ?>
		<?php echo $form->textField($model,'secretary_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forwarded_by_treasurer'); ?>
		<?php echo $form->textField($model,'forwarded_by_treasurer',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'treasurer_date'); ?>
		<?php echo $form->textField($model,'treasurer_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_by_chairman'); ?>
		<?php echo $form->textField($model,'approved_by_chairman',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chairman_date'); ?>
		<?php echo $form->textField($model,'chairman_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'present_net_pay'); ?>
		<?php echo $form->textField($model,'present_net_pay',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'net_pay_after_loan_repayment'); ?>
		<?php echo $form->textField($model,'net_pay_after_loan_repayment',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->