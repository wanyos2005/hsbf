<?php
Yii::import('ext.redactor.ImperaviRedactorWidget');
$this->widget('ImperaviRedactorWidget', array(
    // the textarea selector
    'selector' => '.redactor',
    // some options, see http://imperavi.com/redactor/docs/
    'options' => array(
        'imageUpload' => $this->createUrl('uploadRedactor'),
        'wym' => false,
        'plugins' => array('fullscreen'),
        'imageUploadErrorCallback' => new CJavaScriptExpression(
                'function(obj,json) { alert(json.error); console.log(json.error);}'
        ),
    ),
));
$form_id = 'help-topic-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal')
        ));
?>
<?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-error')); ?>
<div class="control-group">
        <?php echo $form->labelEx($model, 'category_id', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->dropDownList($model, 'category_id', CHtml::listData(array_merge(array(array('id' => '', 'name' => '--select-')), HelpCategory::model()->getData('id,name')), 'id', 'name'), array('class' => 'span8 chzn-select')); ?>
        </div>
</div>
<div class="control-group">
        <?php echo $form->labelEx($model, 'topic', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->textField($model, 'topic', array('class' => 'span8', 'maxlength' => 128)); ?>
        </div>
</div>
<div class="control-group">
        <?php echo $form->labelEx($model, 'body', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->textArea($model, 'body', array('class' => 'span10 redactor', 'rows' => 10)); ?>
        </div>
</div>
<div class="form-actions">
        <button type="submit" class="btn btn-primary"><?php echo Lang::t($model->isNewRecord ? 'Create' : 'Save changes') ?></button>
        <a class="btn" href="<?php echo $this->createUrl('admin') ?>"><?php echo Lang::t('Cancel') ?></a>
</div>
<?php $this->endWidget(); ?>