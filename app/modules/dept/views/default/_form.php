<?php
$form_id = 'users-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'role' => 'form'),
        ));
?>
<div class="row">
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title"><?php echo Lang::t('Department details') ?></h4>
                        </div>
                        <div class="panel-body">
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'name', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-control')); ?>
                                                <?php echo CHtml::error($model, 'name') ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'telephone1', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeTextField($model, 'telephone1', array('class' => 'form-control')); ?>
                                                <?php echo CHtml::error($model, 'telephone1') ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'telephone2', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeTextField($model, 'telephone2', array('class' => 'form-control')); ?>
                                                <?php echo CHtml::error($model, 'telephone2') ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'email', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeEmailField($model, 'email', array('class' => 'form-control')); ?>
                                                <?php echo CHtml::error($model, 'email') ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'address', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeTextArea($model, 'address', array('class' => 'form-control', 'rows' => 3)); ?>
                                                <?php echo CHtml::error($model, 'address') ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'status', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeDropDownList($model, 'status', Dept::statusOptions(), array('class' => 'form-control')); ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title"><?php echo Lang::t('Geo Location') ?></h4>
                        </div>
                        <div class="panel-body">
                                <div class="form-group">
                                        <div class="col-md-10">
                                                <?php echo CHtml::activeDropDownList($model, 'country_id', SettingsCountry::model()->getListData('id', 'name', FALSE), array('class' => 'form-control')); ?>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="col-md-5">
                                                <?php echo CHtml::activeTextField($model, 'latitude', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('latitude'), 'readonly' => true)); ?>
                                        </div>
                                        <div class="col-md-5">
                                                <?php echo CHtml::activeTextField($model, 'longitude', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('longitude'), 'readonly' => true)); ?>
                                        </div>
                                </div>
                                <div class="well" style="height: 200px">
                                        GOOLE MAP HERE
                                </div>
                                <div class="form-group">
                                        <?php echo CHtml::activeLabelEx($model, 'location', array('class' => 'col-md-3 control-label')); ?>
                                        <div class="col-md-8">
                                                <?php echo CHtml::activeTextField($model, 'location', array('class' => 'form-control', 'placeholder' => Lang::t('Type the department location or mark it on the map.'))); ?>
                                                <?php echo CHtml::error($model, 'location') ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>

<div class="clearfix form-actions">
        <div class="col-md-12">
                <button class="btn btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t($model->isNewRecord ? 'Save and Create Contact Person' : 'Save') ?></button>
                &nbsp; &nbsp; &nbsp;
                <a class="btn btn-sm" href="<?php echo Controller::getReturnUrl($model->isNewRecord ? $this->createUrl('index') : $this->createUrl('view', array('id' => $model->id))) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Cancel') ?></a>
        </div>
</div>
<?php $this->endWidget(); ?>