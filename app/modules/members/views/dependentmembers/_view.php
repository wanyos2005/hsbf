<?php
/* @var $this DependentMembersController */
/* @var $data DependentMembers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('principal_member')); ?>:</b>
	<?php echo CHtml::encode($data->principal_member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idno')); ?>:</b>
	<?php echo CHtml::encode($data->idno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alive')); ?>:</b>
	<?php echo CHtml::encode($data->alive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relationship')); ?>:</b>
	<?php echo CHtml::encode($data->relationship); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobileno')); ?>:</b>
	<?php echo CHtml::encode($data->mobileno); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('postaladdress')); ?>:</b>
	<?php echo CHtml::encode($data->postaladdress); ?>
	<br />

	*/ ?>

</div>