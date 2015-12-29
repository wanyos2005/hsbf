<?php
/* @var $this KinsAndNomineesController */
/* @var $data KinsAndNominees */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dependent_member')); ?>:</b>
	<?php echo CHtml::encode($data->dependent_member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kinOrNominee')); ?>:</b>
	<?php echo CHtml::encode($data->kinOrNominee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percent')); ?>:</b>
	<?php echo CHtml::encode($data->percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>