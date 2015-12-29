<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'core-page-form',
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
                        <?php echo $form->textField($model, 'key', array('class' => 'form-control', 'maxlength' => 30)); ?>
                </div>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-5">
                        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'maxlength' => 255)); ?>
                </div>
        </div>
<?php endif ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'title', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
                <p class="help-block">This will appear in the title tag of the page e.g "<span class="text-muted"><?php echo CHtml::encode('<title>what you enter here..</title>') ?></span>"</p>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'maxlength' => 255, 'rows' => 3)); ?>
                <p class="help-block">This will appear in the description meta tag of the page e.g "<span class="text-muted"><?php echo CHtml::encode('<meta name="description" content="what you enter here...">') ?></span>"</p>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'allow_indexing', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <label class="checkbox"><?php echo $form->checkBox($model, 'allow_indexing', array()); ?></label>
                <p class="help-block">If you uncheck this, this tag will be added at the head section of the page:  "<span class="text-muted"><?php echo CHtml::encode('<meta name="robots" content="noindex, nofollow">') ?></span>"</p>
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