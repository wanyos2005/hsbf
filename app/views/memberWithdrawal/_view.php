<?php
/* @var $this MemberWithdrawalController */
/* @var $data MemberWithdrawal */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member')); ?>:</b>
	<?php echo CHtml::encode($data->member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forwarded_by_secretary')); ?>:</b>
	<?php echo CHtml::encode($data->forwarded_by_secretary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forwarded_by_treasurer')); ?>:</b>
	<?php echo CHtml::encode($data->forwarded_by_treasurer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by_chairman')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by_chairman); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secretary_date')); ?>:</b>
	<?php echo CHtml::encode($data->secretary_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('treasurer_date')); ?>:</b>
	<?php echo CHtml::encode($data->treasurer_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chairman_date')); ?>:</b>
	<?php echo CHtml::encode($data->chairman_date); ?>
	<br />

	*/ ?>

</div>