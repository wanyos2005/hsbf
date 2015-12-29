<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#personal_info"><?php echo Lang::t('Personal Information') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->id)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('view', array('id' => $model->id, 'action' => Users::ACTION_UPDATE_PERSONAL)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>
    <div id="personal_info" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">
                <?php
                $this->widget('application.components.widgets.DetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'first_name',
                        ),
                        array(
                            'name' => 'last_name',
                        ),
                        array(
                            'name' => 'gender',
                        ),
                        array(
                            'name' => 'birthdate',
                            'value' => Common::formatDate($model->birthdate, 'd M Y'),
                            'visible' => !empty($model->birthdate),
                        ),
                    array(
                            'name' => 'idno',
                        ),
//                    array(
//                            'name' => 'membershipno',
//                            'visible' => !empty($model->membershipno),
//                        ),
                    array(
                            'name' => 'married',
                           
                        ),
                   
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
