<?php
$form_id = 'help-category-colorboxform';
Yii::app()->clientScript->registerScript('colorbox-form', "
            MyColorBox.init('" . $form_id . "');
    ");
?>
<div class="span6 my-colorbox">
        <div class="row-fluid">
                <div class="span11">
                        <div class="page-header"><h4><?php echo $this->pageTitle ?></h4></div>
                        <div class="alert alert-success hidden" id="my-colorbox-successDiv"></div>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => $form_id,
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('class' => 'form-horizontal')
                        ));
                        ?>
                        <div class="alert alert-error hidden" id="my-colorbox-errorDiv"><ul></ul></div>
                        <div class="clearfix"></div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->textField($model, 'name', array('class' => 'span10', 'maxlength' => 128)); ?>
                                </div>
                        </div>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->textArea($model, 'description', array('class' => 'span10', 'rows' => 5)); ?>
                                </div>
                        </div>
                        <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="my-colorbox-submitButton"><?php echo Lang::t($model->isNewRecord ? 'Create' : 'Save changes') ?></button>
                                <button type="button" class="btn" id="my-colorbox-cancelButton">Cancel</button>
                        </div>
                        <?php $this->endWidget(); ?>
                </div>
        </div>
</div>