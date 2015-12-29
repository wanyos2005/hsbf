<?php
$this->breadcrumbs = array(
    Lang::t($this->resourceLabel) => array('index'),
    $this->pageTitle,
);
?>
<div class="panel panel-default">
        <div class="panel-body">
                <?php echo CHtml::beginForm(Yii::app()->createUrl($this->route, $this->actionParams), 'POST', array('class' => '', 'id' => 'my-roles-view-form', 'role' => 'form')) ?>
                <div class="row">
                        <div class="col-lg-6"><button class="btn btn-link my-select-all" type="button" data-checked="false"><?php echo Lang::t('Check All') ?></button></div>
                        <div class="col-lg-6"><button class="btn btn-primary btn-sm pull-right" type="submit"><?php echo Lang::t('Save Changes') ?></button></div>
                </div>
                <br/>
                <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                                <thead>
                                        <tr><th><?php echo Lang::t('System Resources') ?></th><th><?php echo Lang::t('Can View') ?></th><th><?php echo Lang::t('Can Create') ?></th><th><?php echo Lang::t('Can Update') ?></th><th><?php echo Lang::t('Can Delete') ?></th></tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($resources as $r): ?>
                                                <tr><td><?php echo $r['description'] ?></td><td><?php if (UserResources::model()->get($r['id'], 'viewable') == 1): ?><?php echo CHtml::hiddenField('RolesOnResources[' . $r['id'] . '][view]', 0) ?><?php echo CHtml::checkBox('RolesOnResources[' . $r['id'] . '][view]', UserRolesOnResources::model()->getValue($r['id'], $model->id, 'view'), array('class' => 'my-roles-checkbox')) ?><?php else: ?>N/A<?php endif ?></td><td><?php if (UserResources::model()->get($r['id'], 'createable') == 1): ?><?php echo CHtml::hiddenField('RolesOnResources[' . $r['id'] . '][create]', 0) ?><?php echo CHtml::checkBox('RolesOnResources[' . $r['id'] . '][create]', UserRolesOnResources::model()->getValue($r['id'], $model->id, 'create'), array('class' => 'my-roles-checkbox')) ?><?php else: ?>N/A<?php endif ?></td><td><?php if (UserResources::model()->get($r['id'], 'updateable') == 1): ?><?php echo CHtml::hiddenField('RolesOnResources[' . $r['id'] . '][update]', 0) ?><?php echo CHtml::checkBox('RolesOnResources[' . $r['id'] . '][update]', UserRolesOnResources::model()->getValue($r['id'], $model->id, 'update'), array('class' => 'my-roles-checkbox')) ?><?php else: ?>N/A<?php endif ?></td><td><?php if (UserResources::model()->get($r['id'], 'deleteable') == 1): ?><?php echo CHtml::hiddenField('RolesOnResources[' . $r['id'] . '][delete]', 0) ?><?php echo CHtml::checkBox('RolesOnResources[' . $r['id'] . '][delete]', UserRolesOnResources::model()->getValue($r['id'], $model->id, 'delete'), array('class' => 'my-roles-checkbox')) ?><?php else: ?>N/A<?php endif ?></td></tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>
                </div>
                <?php echo CHtml::endForm(); ?>
        </div>
</div>
<?php Yii::app()->clientScript->registerScript('my-roles-view', "MyController.Users.Roles.init();"); ?>