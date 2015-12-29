<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $data FunzoPersonalDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('APP_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->APP_ID), array('view', 'id'=>$data->APP_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MIDDLE_NAME')); ?>:</b>
	<?php echo CHtml::encode($data->MIDDLE_NAME); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LAST_NAME')); ?>:</b>
	<?php echo CHtml::encode($data->LAST_NAME); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FAST_NAME')); ?>:</b>
	<?php echo CHtml::encode($data->FAST_NAME); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDno')); ?>:</b>
	<?php echo CHtml::encode($data->IDno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PINNO')); ?>:</b>
	<?php echo CHtml::encode($data->PINNO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DOB')); ?>:</b>
	<?php echo CHtml::encode($data->DOB); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('GENDER')); ?>:</b>
	<?php echo CHtml::encode($data->GENDER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EMAIL')); ?>:</b>
	<?php echo CHtml::encode($data->EMAIL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IMPAIRED_IDFK')); ?>:</b>
	<?php echo CHtml::encode($data->IMPAIRED_IDFK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEL_')); ?>:</b>
	<?php echo CHtml::encode($data->TEL_); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BOX_NO')); ?>:</b>
	<?php echo CHtml::encode($data->BOX_NO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('POSTAL_CODE')); ?>:</b>
	<?php echo CHtml::encode($data->POSTAL_CODE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TOWN')); ?>:</b>
	<?php echo CHtml::encode($data->TOWN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LOCATION')); ?>:</b>
	<?php echo CHtml::encode($data->LOCATION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DIVISION')); ?>:</b>
	<?php echo CHtml::encode($data->DIVISION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DISTRICT_IDFK')); ?>:</b>
	<?php echo CHtml::encode($data->DISTRICT_IDFK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('APPLICATION_TYPE')); ?>:</b>
	<?php echo CHtml::encode($data->APPLICATION_TYPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SERIAL_NO')); ?>:</b>
	<?php echo CHtml::encode($data->SERIAL_NO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EMPLOYED')); ?>:</b>
	<?php echo CHtml::encode($data->EMPLOYED); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CONSTITUENCY_IDFK')); ?>:</b>
	<?php echo CHtml::encode($data->CONSTITUENCY_IDFK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FORM_PRINT')); ?>:</b>
	<?php echo CHtml::encode($data->FORM_PRINT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_POSTED')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_POSTED); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COUNTY_IDFK')); ?>:</b>
	<?php echo CHtml::encode($data->COUNTY_IDFK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('M_STATUS')); ?>:</b>
	<?php echo CHtml::encode($data->M_STATUS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SPOUSE_NAME')); ?>:</b>
	<?php echo CHtml::encode($data->SPOUSE_NAME); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CURR_COUNTY_IDFK')); ?>:</b>
	<?php echo CHtml::encode($data->CURR_COUNTY_IDFK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LOAN_TYPE')); ?>:</b>
	<?php echo CHtml::encode($data->LOAN_TYPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SERVICE_TYPE')); ?>:</b>
	<?php echo CHtml::encode($data->SERVICE_TYPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DOB_D')); ?>:</b>
	<?php echo CHtml::encode($data->DOB_D); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DOB_M')); ?>:</b>
	<?php echo CHtml::encode($data->DOB_M); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DOB_Y')); ?>:</b>
	<?php echo CHtml::encode($data->DOB_Y); ?>
	<br />

	*/ ?>

</div>