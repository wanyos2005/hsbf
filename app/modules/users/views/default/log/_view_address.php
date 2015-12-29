<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#address_info"><?php echo Lang::t('Address Information') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->person_id)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('view', array('id' => $model->person_id, 'action' => Users::ACTION_UPDATE_ADDRESS)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>
    <div id="address_info" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">
                <?php
                $this->widget('application.components.widgets.DetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'phone1',
                        ),
                        array(
                            'name' => 'phone2',
                        ),
                        array(
                            'name' => 'address',
                        ),
                        array(
                            'name' => 'residence',
                        ),
                        array(
                            'name' => 'address2',
                        ),
                        array(
                            'name' => 'residence2',
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>