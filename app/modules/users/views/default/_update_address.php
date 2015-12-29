<?php
$form_id = 'person-address-form';
$form = $this->beginWidget('CActiveForm', array(
    'id' => $form_id,
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
        ));

$person_model = Person::model()->findByPk($model->person_id);
?>
<div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><?php echo Lang::t('Update Address Information') ?></h3></div>
        <div class="panel-body">
                <div class="row">
                        <div class="col-md-8 col-sm-12">
                                <?php $this->renderPartial('application.views.person._address_fields', array('model' => $model, 'label_size' => 3, 'input_size' => 8)) ?>
                        </div>
                </div>
        </div>
        <div class="panel-footer clearfix">
                <button class="btn btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>
                &nbsp; &nbsp; &nbsp;
                <a class="btn btn-sm" href="<?php echo Controller::getReturnUrl($this->createUrl('view', array('id' => $model->person_id))) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
                
                <a class="pull-right btn btn-sm btn-primary" href="<?php echo Controller::getReturnUrl($this->createUrl('/members/dependentMembers/create', array('id' => $model->person_id, 'rltn1' => $m = $person_model->married == 'y' ? 4 : ($person_model->havechildren == 'y' ? 5 : 1), 'rltn2' => $m + 5, 'action' => Users::ACTION_ADD_DEPENDENTS))) ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                
                <a class="pull-right" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</a>
                
                <a class="pull-right btn btn-sm btn-primary" href="<?php echo Controller::getReturnUrl($this->createUrl('view', array('id' => $model->person_id, 'action' => Users::ACTION_UPDATE_PERSONAL))) ?>"><i class="fa fa-chevron-left"></i> <?php echo Lang::t('Back') ?></a>
        </div>
</div>

<?php $this->endWidget(); ?>