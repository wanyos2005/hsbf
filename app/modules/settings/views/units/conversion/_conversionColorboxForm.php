<?php
$form_id = $model->getClassName() . '_colorboxform';
?>
<div class="my-colobox">
        <div class="page-header">
                <h1><?php echo CHtml::encode($this->pageTitle) ?></h1>
        </div>
        <div class="alert hidden" id="my-colorbox-notif"></div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => $form_id,
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form')
        ));
        ?>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'from_unit_id', array('class' => 'col-lg-4 control-label')); ?>
                <div class="col-lg-8">
                        <?php echo $form->dropDownList($model, 'from_unit_id', SettingsUnitsOfMeasure::model()->getListData('id', 'name'), array('class' => 'form-control', 'data-ajax-link' => $this->createUrl('getToList'))); ?>
                </div>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'to_unit_id', array('class' => 'col-lg-4 control-label')); ?>
                <div class="col-lg-8">
                        <i class="fa fa-spinner fa-2x my-icon-loading fa-spin hidden"></i>
                        <?php echo $form->dropDownList($model, 'to_unit_id', array(), array('class' => 'form-control', 'disabled' => true, 'data-selected-option' => $model->to_unit_id)); ?>
                </div>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'value', array('class' => 'col-lg-4 control-label')); ?>
                <div class="col-lg-8">
                        <?php echo $form->textField($model, 'value', array('class' => 'form-control')); ?>
                </div>
        </div>
        <div class="clearfix form-actions">
                <div class="col-lg-offset-4 col-lg-8">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t($model->isNewRecord ? 'Create' : 'Save changes') ?></button>
                        &nbsp; &nbsp; &nbsp;
                        <button type="cancel" class="btn btn-sm">Cancel</button>
                </div>
        </div>
        <?php $this->endWidget(); ?>
</div>
<?php
$this->beginWidget('ext.MyColorbox.MyColorbox', array(
    'FormSelector' => '#' . $form_id,
));
$this->endWidget();
Yii::app()->clientScript->registerScript('units-conversion', "
          MyController.Settings.Units.init();
");
?>