<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#account_info"><?php echo Lang::t('Account Details') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->id)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('view', array('id' => $model->id, 'action' => Users::ACTION_UPDATE_ACCOUNT)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>
    <div id="account_info" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="detail-view">
                <?php
                $this->widget('application.components.widgets.DetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'id',
                        ),
                        array(
                            'label' => Lang::t('Department'),
                            'visible' => !empty($model->dept_id),
                            'value' => CHtml::link(CHtml::encode(Dept::model()->get($model->dept_id, "name")), Yii::app()->createUrl('dept/default/view', array('id' => $model->dept_id)), array()),
                            'type' => 'raw',
                        ),
                        array(
                            'name' => 'status',
                            'value' => CHtml::tag('span', array('class' => $model->status === Users::STATUS_ACTIVE ? 'badge badge-success' : 'badge badge-danger'), $model->status),
                            'type' => 'raw',
                        ),
                        array(
                            'name' => 'username',
                        ),
                        array(
                            'name' => 'email',
                        ),
                        array(
                            'name' => 'user_level',
                        ),
                        array(
                            'name' => 'role_id',
                            'visible' => !empty($model->role_id),
                            'value' => UserRoles::model()->get($model->role_id, 'name'),
                        ),
                        array(
                            'name' => 'timezone',
                        ),
                        array(
                            'name' => 'date_created',
                            'value' => MyYiiUtils::formatDate($model->date_created),
                        ),
                        array(
                            'name' => 'created_by',
                            'value' => Users::model()->get($model->created_by, "username"),
                            'visible' => !empty($model->created_by),
                        ),
                        array(
                            'name' => 'last_modified',
                            'value' => MyYiiUtils::formatDate($model->last_modified),
                            'visible' => !empty($model->last_modified),
                        ),
                        array(
                            'name' => 'last_modified_by',
                            'value' => Users::model()->get($model->last_modified_by, "username"),
                            'visible' => !empty($model->last_modified_by),
                        ),
                        array(
                            'name' => 'last_login',
                            'value' => MyYiiUtils::formatDate($model->last_login),
                        )
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>