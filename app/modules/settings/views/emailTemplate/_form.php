<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'email-template-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    )
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<?php if (Yii::app()->user->user_level === UserLevels::LEVEL_ENGINEER): ?>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'key', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-5">
                        <?php echo $form->textField($model, 'key', array('class' => 'form-control', 'maxlength' => 128)); ?>
                </div>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'description', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-5">
                        <?php echo $form->textField($model, 'description', array('class' => 'form-control', 'maxlength' => 128)); ?>
                </div>
        </div>
<?php endif ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'subject', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'subject', array('class' => 'form-control', 'maxlength' => 255)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'from', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'from', array('class' => 'form-control', 'maxlength' => 255)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'body', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-8">
                <?php echo $form->textArea($model, 'body', array('class' => 'form-control redactor', 'rows' => 6)); ?>
                <p class="help-block">NOTE: Please DO NOT remove placeholders (words enclosed with {}). You are free to reorganize the body template and add other words or html tags but do not remove the placeholders</p>
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
<?php
Yii::import('ext.redactor.ImperaviRedactorWidget');
$this->widget('ImperaviRedactorWidget', array(
    // the textarea selector
    'selector' => '.redactor',
    // some options, see http://imperavi.com/redactor/docs/
    'options' => array(
        'minHeight' => 200,
        'convertDivs' => false,
        'cleanup' => TRUE,
        'paragraphy' => false,
        'imageUpload' => Yii::app()->createUrl('myHelper/uploadRedactor'),
        'imageUploadErrorCallback' => new CJavaScriptExpression(
                'function(obj,json) {console.log(json.error);}'
        ),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
    ),
));
?>