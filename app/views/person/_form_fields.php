<?php
if (!isset($label_size)):
    $label_size = 2;
endif;
if (!isset($input_size)):
    $input_size = 8;
endif;

$label_class = "col-md-{$label_size} control-label";
$input_class = "col-md-{$input_size}";
$half_input_size = $input_size / 2;
$half_input_class = "col-md-{$half_input_size}";
?>
<div class="form-group">
     
     <?php echo CHtml::activeLabelEx($model, 'Name', array('class' => $label_class)); ?>
     <div class="<?php echo $half_input_class ?>">
        <?php echo CHtml::activeTextField($model, 'first_name', array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('first_name'))); ?>
        <?php echo CHtml::error($model, 'first_name') ?>
    </div>
    <div class="<?php echo $half_input_class ?>">
        <?php echo CHtml::activeTextField($model, 'last_name', array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('last_name'))); ?>
        <?php echo CHtml::error($model, 'last_name') ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'idno', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php echo CHtml::activeTextField($model, 'idno', array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('idno'))); ?>
        <?php echo CHtml::error($model, 'idno') ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'gender', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php echo CHtml::activeRadioButtonList($model, 'gender', Person::genderOptions(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;')); ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'birthdate', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>">
        <?php echo CHtml::activeDropDownList($model, 'birthdate_month', Person::birthDateMonthOptions(), array('style' => 'width:80px;')); ?>&nbsp;&nbsp;
        <?php echo CHtml::activeDropDownList($model, 'birthdate_day', Person::birthDateDayOptions(), array('style' => 'width:80px;')); ?>&nbsp;&nbsp;
        <?php echo CHtml::activeDropDownList($model, 'birthdate_year', Person::birthDateYearOptions(), array('style' => 'width:80px;')); ?>
        <?php echo CHtml::error($model, 'birthdate') ?>
    </div>
</div>

<!--
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'membershipno', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php echo CHtml::activeTextField($model, 'membershipno', array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('membershipno'))); ?>
        <?php echo CHtml::error($model, 'membershipno') ?>
    </div>
</div>
-->
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'department', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php
        $depts = Departments::model()->findAll(array('order' => 'department ASC'));
        $depts = CHtml::listData($depts, 'id', 'department')
        ?>
        <?php echo CHtml::activeDropDownList($model, 'department', $depts, array('prompt' => $model->getAttributeLabel('department'), 'class' => 'form-control')); ?>
        <?php echo CHtml::error($model, 'department') ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'payrollno', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php echo CHtml::activeTextField($model, 'payrollno', array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('payrollno'))); ?>
        <?php echo CHtml::error($model, 'payrollno') ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'married', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php
        $depts = array('y' => 'Yes', 'n' => 'No');
        $model->married = empty($model->married) ? 'n' : $model->married;
        ?>
        <?php echo CHtml::activeDropDownList($model, 'married', $depts, array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('married'))); ?>
        <?php echo CHtml::error($model, 'married') ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'havechildren', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>" style="padding-top: 4px;">
        <?php
        $model->havechildren = empty($model->havechildren) ? 'n' : $model->havechildren;
        ?>
        <?php echo CHtml::activeDropDownList($model, 'havechildren', $depts, array('class' => 'form-control', 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('havechildren'))); ?>
        <?php echo CHtml::error($model, 'havechildren') ?>
    </div>
</div>
<?php $this->renderPartial('application.views.person._image_field', array('model' => $model, 'htmlOptions' => array('label_class' => $label_class, 'field_class' => $input_class))) ?>



