<?php
$form_id = 'users-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
        ));
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo Lang::t('Change your password') ?></h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'currentPassword', array('class' => 'col-md-4 control-label')); ?>
                    <div class="col-md-7">
                        <?php echo $form->passwordField($model, 'currentPassword', array('class' => 'form-control')); ?>
                        <?php echo CHtml::error($model, 'currentPassword') ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'col-md-4 control-label')); ?>
                    <div class="col-md-7">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                        <?php echo CHtml::error($model, 'password') ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'confirm', array('class' => 'col-md-4 control-label')); ?>
                    <div class="col-md-7">
                        <?php echo $form->passwordField($model, 'confirm', array('class' => 'form-control')); ?>
                        <?php echo CHtml::error($model, 'confirm') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <button class="btn btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Change Password') ?></button>
        &nbsp; &nbsp; &nbsp;
        <a class="btn btn-sm" href="<?php echo Controller::getReturnUrl($this->createUrl('view', array('id' => $model->id))) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
    </div>
</div>
<?php $this->endWidget(); ?>