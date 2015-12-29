<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-levels-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form')
        ));
?>
<?php echo $form->errorSummary($model, ''); ?>
<div class="form-group">
        <?php echo $form->labelEx($model, 'rank', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'rank', array('class' => 'form-control')); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'id', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'maxlength' => 30)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->textField($model, 'description', array('class' => 'form-control', 'maxlength' => 60)); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'banned_resources', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->dropDownList($model, 'banned_resources', UserResources::model()->getListData('id', 'id', false), array('multiple' => 'multiple', 'class' => 'form-control chosen-select')); ?>
        </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($model, 'banned_resources_inheritance', array('class' => 'col-lg-2 control-label')); ?>
        <div class="col-lg-5">
                <?php echo $form->dropDownList($model, 'banned_resources_inheritance', UserLevels::model()->getListData('id', 'id', true), array('class' => 'form-control')); ?>
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
Yii::app()->clientScript
        ->registerCssFile(Yii::app()->theme->baseUrl . '/plugins/chosen/chosen.min.css')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/chosen/chosen.jquery.min.js', CClientScript::POS_END)
        ->registerScript('user-levels', "$('.chosen-select').chosen();");
?>