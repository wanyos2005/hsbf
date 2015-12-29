<?php
$name = Person::model()->get($model->contact_person_id, 'CONCAT(first_name," ",last_name)');
$email = Users::model()->get($model->contact_person_id, 'email');
$phone = PersonAddress::model()->getScaler('phone1', '`person_id`=:t1', array(':t1' => $model->contact_person_id));
?>
<div class="panel-group" id="accordion1">
        <div class="panel panel-default">
                <div class="panel-heading">
                        <h4 class="panel-title">
                                <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion1" href="#store_contact_person"><?php echo Lang::t('Contact Person') ?></a>
                                <?php if (!empty($model->contact_person_id) && $this->showLink(UserResources::RES_USER_ADMIN)): ?>
                                        <span><a class="pull-right" href="<?php echo Yii::app()->createUrl('users/default/view', array('id' => $model->contact_person_id)) ?>"><?php echo Lang::t('View full profile') ?> <i class="fa fa-external-link"></i></a></span>
                                <?php endif; ?>
                        </h4>
                </div>
                <div id="store_contact_person" class="panel-collapse collapse in">
                        <div class="panel-body">
                                <?php if (!empty($model->contact_person_id)): ?>
                                        <p><i class="icon-user"></i> <?php echo CHtml::encode($name) ?></p>
                                        <p><i class="icon-envelope"></i> <?php echo CHtml::encode($email) ?></p>
                                        <?php if (!empty($phone)): ?>
                                                <p><i class="fa fa-phone"></i> <?php echo CHtml::encode($phone) ?></p>
                                        <?php endif; ?>
                                <?php else: ?>
                                        <div class="alert alert-warning">
                                                <a href="<?php echo Yii::app()->createUrl('users/default/create', array('dept_id' => $model->id, Controller::GET_PARAM_RETURN_URL => Yii::app()->createUrl($this->route, $this->actionParams))) ?>"><?php echo Lang::t('No contact person for this department. Create one.') ?></a>
                                        </div>
                                <?php endif; ?>
                        </div>
                </div>
        </div>
</div>