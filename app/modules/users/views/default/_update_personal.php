<?php
$form_id = 'person-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'role' => 'form'),
        ));
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo Lang::t('Update Personal Information') ?></h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <?php $this->renderPartial('application.views.person._form_fields', array('model' => $model, 'label_size' => 3, 'input_size' => 8)) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>
        &nbsp; &nbsp; &nbsp;
        <a class="btn btn-sm" href="<?php echo Controller::getReturnUrl($this->createUrl('view', array('id' => $model->id))) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>

        <a class="pull-right btn btn-sm btn-primary" href="<?php echo Controller::getReturnUrl($this->createUrl('view', array('id' => $model->id, 'action' => Users::ACTION_UPDATE_ADDRESS))) ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
    </div>
</div>

<?php $this->endWidget(); ?>