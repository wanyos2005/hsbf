<?php
$grid_id = 'cron-tasks-grid';
?>
<!--grid header-->
<div class="row grid-view-header">
        <div class="col-sm-12">
                <div class="btn-group">
                        <?php if ($this->showLink($this->resource, Acl::ACTION_CREATE)): ?><a class="btn btn-sm" href="<?php echo $this->createUrl('create') ?>"><i class="icon-plus-sign"></i> <?php echo Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel) ?></a><?php endif; ?>
                </div>
        </div>
</div>
<?php
$this->widget('application.components.widgets.GridView', array(
    'id' => $grid_id,
    'dataProvider' => $model->search(),
    'enablePagination' => $model->enablePagination,
    'enableSummary' => $model->enableSummary,
    'columns' => array(
        'id',
        'execution_type',
        array(
            'name' => 'last_run',
            'value' => 'Common::formatDate($data->last_run,"d/m/Y g:i:s a")',
        ),
        'threads',
        'max_threads',
        'sleep',
        array(
            'name' => 'status',
            'value' => 'CHtml::tag("span", array("class" => $data->status==="' . ConsoleTasks::STATUS_ACTIVE . '"?"badge badge-success":"badge"), $data->status)',
            'type' => 'raw',
        ),
        array(
            'class' => 'ButtonColumn',
            'template' => '{start}{stop}{update}{delete}',
            'buttons' => array(
                'start' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-ok bigger-130"></i> ' . Lang::t('Start'),
                    'url' => 'Yii::app()->controller->createUrl("start",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_CRON . '","' . Acl::ACTION_UPDATE . '") && ($data->status==="' . ConsoleTasks::STATUS_INACTIVE . '")?true:false',
                    'options' => array(
                        'class' => 'btn btn-sm btn-success',
                        'onclick' => "return MyUtils.GridView.submitGridView('{$grid_id}',$(this).attr('href'))",
                        'title' => Lang::t('Start the process'),
                    ),
                ),
                'stop' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-remove bigger-130"></i> ' . Lang::t('Stop'),
                    'url' => 'Yii::app()->controller->createUrl("stop",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_CRON . '","' . Acl::ACTION_UPDATE . '") && ($data->status==="' . ConsoleTasks::STATUS_ACTIVE . '")?true:false',
                    'options' => array(
                        'class' => 'btn btn-sm btn-danger',
                        'onclick' => "return MyUtils.GridView.submitGridView('{$grid_id}',$(this).attr('href'))",
                        'title' => Lang::t('Stop all processes'),
                    ),
                ),
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil bigger-130"></i> ' . Lang::t(Constants::LABEL_UPDATE),
                    'url' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_CRON . '","' . Acl::ACTION_UPDATE . '")?true:false',
                    'options' => array(
                        'class' => 'btn btn-sm btn-info',
                        'title' => Lang::t(Constants::LABEL_UPDATE),
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-trash bigger-130"></i> ' . Lang::t(Constants::LABEL_DELETE),
                    'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_CRON . '", "' . Acl::ACTION_DELETE . '")&& $data->canDelete()?true:false',
                    'options' => array(
                        'class' => 'btn btn-sm btn-danger delete',
                        'title' => Lang::t(Constants::LABEL_DELETE),
                    ),
                ),
            )
        ),
    ),
));
?>