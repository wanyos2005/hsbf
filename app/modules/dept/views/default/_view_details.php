<div class="panel-group" id="accordion3">
        <div class="panel panel-default">
                <div class="panel-heading">
                        <h4 class="panel-title">
                                <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion3" href="#store_details"><?php echo Lang::t('Details') ?></a>
                                <?php if ($this->showLink(UserResources::RES_DEPT)): ?>
                                        <span><a class="pull-right" href="<?php echo $this->createUrl('update', array('id' => $model->id)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
                                <?php endif; ?>
                        </h4>
                </div>
                <div id="store_details" class="panel-collapse collapse in">
                        <div class="panel-body">
                                <?php
                                $this->widget('zii.widgets.CDetailView', array(
                                    'data' => $model,
                                    'nullDisplay' => '______',
                                    'attributes' => array(
                                        array(
                                            'name' => 'id',
                                        ),
                                        array(
                                            'name' => 'status',
                                            'value' => CHtml::tag('span', array('class' => $model->status === Dept::STATUS_OPEN ? 'badge badge-success' : 'badge badge-danger'), $model->status),
                                            'type' => 'raw',
                                        ),
                                        array(
                                            'name' => 'name',
                                        ),
                                        array(
                                            'name' => 'telephone1',
                                        ),
                                        array(
                                            'name' => 'telephone2',
                                        ),
                                        array(
                                            'name' => 'email',
                                        ),
                                        array(
                                            'name' => 'address',
                                        ),
                                        array(
                                            'name' => 'country_id',
                                        ),
                                        array(
                                            'name' => 'location',
                                        ),
                                        array(
                                            'name' => 'date_created',
                                            'value' => MyYiiUtils::formatDate($model->date_created),
                                        ),
                                        array(
                                            'name' => 'created_by',
                                            'value' => CHtml::encode(Person::model()->get($model->created_by, 'CONCAT(first_name," ",last_name)')),
                                        ),
                                        array(
                                            'name' => 'last_modified',
                                            'value' => MyYiiUtils::formatDate($model->last_modified),
                                            'visible' => !empty($model->last_modified),
                                        ),
                                        array(
                                            'name' => 'last_modified_by',
                                            'value' => CHtml::encode(Person::model()->get($model->last_modified_by, 'CONCAT(first_name," ",last_name)')),
                                            'visible' => !empty($model->last_modified_by),
                                        ),
                                    ),
                                ));
                                ?>
                        </div>
                </div>
        </div>
</div>