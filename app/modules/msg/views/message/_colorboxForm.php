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
                <?php echo $form->labelEx($model, 'topic', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                        <?php echo $form->textField($model, 'topic', array('class' => 'form-control', 'maxlength' => 255)); ?>
                </div>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model, 'message', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                        <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'rows' => 6)); ?>
                </div>
        </div>
        <div class="clearfix form-actions">
                <div class="col-lg-offset-3 col-lg-9">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Send Message') ?></button>
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
?>
