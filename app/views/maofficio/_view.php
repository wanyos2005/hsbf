<?php
/* @var $this MaofficioController */
/* @var $data Maofficio */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post')); ?>:</b>
	<?php echo CHtml::encode($data->post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member')); ?>:</b>
	<?php echo CHtml::encode($data->member); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('since')); ?>:</b>
	<?php echo CHtml::encode($data->since); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('till')); ?>:</b>
	<?php echo CHtml::encode($data->till); ?>
	<br />


</div>