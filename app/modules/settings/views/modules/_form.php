<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'modules-enabled-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    )
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'id', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'maxlength' => 30)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 30)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'rows' => 3, 'maxlength' => 255)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'status', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->dropDownList($model, 'status', ModulesEnabled::getStatuses(), array('class' => 'form-control')); ?>
        </div>
</div>
<div class="clearfix form-actions">
        <div class="col-lg-offset-2 col-lg-9">
                <button class="btn btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t($model->isNewRecord ? 'Create' : 'Save changes') ?></button>
                &nbsp; &nbsp; &nbsp;
                <a class="btn" href="<?php echo $this->createUrl('index') ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Cancel') ?></a>
        </div>
</div>
<?php $this->endWidget(); ?>