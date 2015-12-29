<?php
$form_id = 'help-category-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal full-fill')
        ));
?>
<?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-error')); ?>
<div class="control-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->textField($model, 'name', array('class' => 'span5', 'maxlength' => 128)); ?>
        </div>
</div>
<div class="control-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->textArea($model, 'description', array('class' => 'span5 redactor', 'rows' => 5)); ?>
        </div>
</div>
<div class="form-actions">
        <button type="submit" class="btn btn-primary"><?php echo Lang::t($model->isNewRecord ? 'Create' : 'Save changes') ?></button>
        <a class="btn" href="<?php echo $this->createUrl('helpCategory') ?>"><?php echo Lang::t('Cancel') ?></a>
</div>
<?php $this->endWidget(); ?>