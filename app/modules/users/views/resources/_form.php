<?php
$form_id = 'user-resources-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form')
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'id', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'maxlength' => 128)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'description', array('class' => 'form-control', 'maxlength' => 255)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'viewable', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <label class="checkbox"><?php echo $form->checkBox($model, 'viewable', array()); ?></label>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'createable', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <label class="checkbox"><?php echo $form->checkBox($model, 'createable', array()); ?></label>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'updateable', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <label class="checkbox"><?php echo $form->checkBox($model, 'updateable', array()); ?></label>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'deleteable', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <label class="checkbox"><?php echo $form->checkBox($model, 'deleteable', array()); ?></label>
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