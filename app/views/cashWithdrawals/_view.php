<?php
/* @var $this CashWithdrawalsController */
/* @var $data CashWithdrawals */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member')); ?>:</b>
	<?php echo CHtml::encode($data->member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_or_cheque')); ?>:</b>
	<?php echo CHtml::encode($data->cash_or_cheque); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_no')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_by_secretary')); ?>:</b>
	<?php echo CHtml::encode($data->received_by_secretary); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('secretary_date')); ?>:</b>
	<?php echo CHtml::encode($data->secretary_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by_chairman')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by_chairman); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chairman_date')); ?>:</b>
	<?php echo CHtml::encode($data->chairman_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('effected_by_treasurer')); ?>:</b>
	<?php echo CHtml::encode($data->effected_by_treasurer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treasurer_date')); ?>:</b>
	<?php echo CHtml::encode($data->treasurer_date); ?>
	<br />

	*/ ?>

</div>