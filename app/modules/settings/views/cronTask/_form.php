<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cron-tasks-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    )
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<?php if ($model->isNewRecord): ?>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'id', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-4">
                        <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'maxlength' => 30)); ?>
                </div>
        </div>
<?php endif; ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'status', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->dropDownList($model, 'status', $model->getStatuses(), array('class' => 'form-control')); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'execution_type', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-4">
                <?php echo $form->dropDownList($model, 'execution_type', $model->getExecutionTypes(), array('class' => 'form-control')); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'max_threads', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-1">
                <?php echo $form->textField($model, 'max_threads', array('class' => 'form-control')); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'sleep', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-1">
                <?php echo $form->textField($model, 'sleep', array('class' => 'form-control')); ?>
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