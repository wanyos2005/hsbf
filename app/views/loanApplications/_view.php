<?php
/* @var $this LoanApplicationsController */
/* @var $data LoanApplications */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member')); ?>:</b>
	<?php echo CHtml::encode($data->member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loan_type')); ?>:</b>
	<?php echo CHtml::encode($data->loan_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amout_borrowed')); ?>:</b>
	<?php echo CHtml::encode($data->amout_borrowed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_period')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('witness')); ?>:</b>
	<?php echo CHtml::encode($data->witness); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('guarantor1')); ?>:</b>
	<?php echo CHtml::encode($data->guarantor1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('guarantor2')); ?>:</b>
	<?php echo CHtml::encode($data->guarantor2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('witness_date')); ?>:</b>
	<?php echo CHtml::encode($data->witness_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('guarantor1_date')); ?>:</b>
	<?php echo CHtml::encode($data->guarantor1_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('guarantor2_date')); ?>:</b>
	<?php echo CHtml::encode($data->guarantor2_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forwarded_by_secretary')); ?>:</b>
	<?php echo CHtml::encode($data->forwarded_by_secretary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secretary_date')); ?>:</b>
	<?php echo CHtml::encode($data->secretary_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forwarded_by_treasurer')); ?>:</b>
	<?php echo CHtml::encode($data->forwarded_by_treasurer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treasurer_date')); ?>:</b>
	<?php echo CHtml::encode($data->treasurer_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by_chairman')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by_chairman); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chairman_date')); ?>:</b>
	<?php echo CHtml::encode($data->chairman_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('present_net_pay')); ?>:</b>
	<?php echo CHtml::encode($data->present_net_pay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_pay_after_loan_repayment')); ?>:</b>
	<?php echo CHtml::encode($data->net_pay_after_loan_repayment); ?>
	<br />

	*/ ?>

</div>