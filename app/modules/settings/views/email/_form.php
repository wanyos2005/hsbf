<?php
$form_id = 'email-queue-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'uk-form uk-form-horizontal uk-panel uk-panel-box')
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<div class="uk-form-row">
        <?php echo $form->labelEx($model, 'from_email', array('class' => 'uk-form-label', 'label' => 'From Email:')); ?>
        <div class="uk-form-controls">
                <?php echo $form->textField($model, 'from_email', array('class' => 'uk-form-width-large', 'maxlength' => 128)); ?>
        </div>
</div>
<div class="uk-form-row">
        <?php echo $form->labelEx($model, 'from_name', array('class' => 'uk-form-label', 'label' => 'From Name:')); ?>
        <div class="uk-form-controls">
                <?php echo $form->textField($model, 'from_name', array('class' => 'uk-form-width-large', 'maxlength' => 60)); ?>
        </div>
</div>
<div class="uk-form-row">
        <?php echo $form->labelEx($model, 'subject', array('class' => 'uk-form-label', 'label' => 'Subject:')); ?>
        <div class="uk-form-controls">
                <?php echo $form->textField($model, 'subject', array('class' => 'uk-form-width-large', 'maxlength' => 255)); ?>
        </div>
</div>
<div class="uk-form-row">
        <?php echo $form->labelEx($model, 'message', array('class' => 'uk-form-label', 'label' => 'Message:')); ?>
        <div class="uk-form-controls">
                <?php echo $form->textArea($model, 'message', array('class' => 'uk-form-width-large redactor', 'rows' => 6)); ?>
        </div>
</div>
<div class="uk-form-row">
        <?php echo $form->labelEx($model, 'send_type', array('class' => 'uk-form-label', 'label' => 'Type:')); ?>
        <div class="uk-form-controls">
                <?php echo $form->dropDownList($model, 'send_type', $model->sendTypeOptions(), array('class' => 'uk-form-width-medium')); ?>
        </div>
</div>
<hr/>
<div class="uk-form-row">
        <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" type="submit"><?php echo Lang::t('Send Now') ?></button>
                <a class="uk-button" href="<?php echo $this->createUrl('default/index') ?>">Cancel</a>
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
        'minHeight' => 150,
        'convertDivs' => false,
        'cleanup' => TRUE,
        'paragraphy' => false,
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
    ),
));
?>