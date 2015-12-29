<?php
$form_id = 'core-static-sections-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form',)
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<?php if (Yii::app()->user->user_level === UserLevels::LEVEL_ENGINEER): ?>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'key', array('class' => 'col-lg-2 control-label', 'label' => $model->getAttributeLabel('key') . ':')); ?>
                <div class="col-lg-5">
                        <?php echo $form->textField($model, 'key', array('class' => 'form-control', 'maxlength' => 64)); ?>
                </div>
        </div>
<?php endif; ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-lg-2 control-label', 'label' => $model->getAttributeLabel('name') . ':')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 128)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'content', array('class' => 'col-lg-2 control-label', 'label' => $model->getAttributeLabel('content') . ':')); ?>
        <div class="col-lg-8">
                <label class="checkbox"><?php echo CHtml::checkBox('toggle_richtext', true, array('id' => 'myredactor_toggle_richtext')) ?>  Enable RichText</label>
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control redactor', 'rows' => 8)); ?>
                <p class="help-block"><?php echo CHtml::encode($model->comments); ?></p>
        </div>
</div>
<?php if (Yii::app()->user->user_level === UserLevels::LEVEL_ENGINEER): ?>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'comments', array('class' => 'col-lg-2 control-label', 'label' => $model->getAttributeLabel('comments') . ':')); ?>
                <div class="col-lg-5">
                        <?php echo $form->textArea($model, 'comments', array('class' => 'form-control', 'rows' => 3)); ?>
                </div>
        </div>
<?php endif; ?>
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
        'cleanup' => true,
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
Yii::app()->clientScript->registerScript($form_id, "
   $('#myredactor_toggle_richtext').change(function() {
        if($(this).is(':checked')) {
            MyRedactor.recreate();
        }
        else{
            MyRedactor.destroy();
        }
    });
");
?>