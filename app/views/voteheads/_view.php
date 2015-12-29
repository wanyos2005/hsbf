<?php
/* @var $this VoteheadsController */
/* @var $data Voteheads */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('votehead')); ?>:</b>
	<?php echo CHtml::encode($data->votehead); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('incomeOrExpense')); ?>:</b>
	<?php echo CHtml::encode($data->incomeOrExpense); ?>
	<br />


</div>