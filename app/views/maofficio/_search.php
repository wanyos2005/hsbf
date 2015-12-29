<?php
/* @var $this MaofficioController */
/* @var $model Maofficio */
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
		<?php echo $form->label($model,'post'); ?>
		<?php echo $form->textField($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'member'); ?>
		<?php echo $form->textField($model,'member'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'since'); ?>
		<?php echo $form->textField($model,'since'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'till'); ?>
		<?php echo $form->textField($model,'till'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->