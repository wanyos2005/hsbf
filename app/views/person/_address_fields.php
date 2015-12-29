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
    <label class="<?php echo $label_class ?>"><?php echo Lang::t('Phone') ?></label>
    <div class="<?php echo $half_input_class ?>">
        <?php echo CHtml::activeTextField($model, 'phone1', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone1'))); ?>
        <?php echo CHtml::error($model, 'phone1') ?>
    </div>
    <div class="<?php echo $half_input_class ?>">
        <?php echo CHtml::activeTextField($model, 'phone2', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone2'))); ?>
        <?php echo CHtml::error($model, 'phone2') ?>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'address', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>">
        <?php echo CHtml::activeTextArea($model, 'address', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo CHtml::error($model, 'address') ?>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'residence', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>">
        <?php echo CHtml::activeTextArea($model, 'residence', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo CHtml::error($model, 'residence') ?>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'address2', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>">
        <?php echo CHtml::activeTextArea($model, 'address2', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo CHtml::error($model, 'address2') ?>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::activeLabelEx($model, 'residence2', array('class' => $label_class)); ?>
    <div class="<?php echo $input_class ?>">
        <?php echo CHtml::activeTextArea($model, 'residence2', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo CHtml::error($model, 'residence2') ?>
    </div>
</div>

