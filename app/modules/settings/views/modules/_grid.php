<?php
$grid_id = 'modules-enabled-grid';
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
        'name',
        'description',
        array(
            'name' => 'status',
            'value' => 'CHtml::tag("span", array("class" => $data->status==="' . ModulesEnabled::STATUS_ENABLED . '"?"badge badge-success":"badge badge-danger"), $data->status)',
            'type' => 'raw',
        ),
        array(
            'class' => 'ButtonColumn',
            'template' => '{enable}{disable}{update}{delete}',
            'buttons' => array(
                'enable' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-ok bigger-130"></i> ' . Lang::t('Enable'),
                    'url' => 'Yii::app()->controller->createUrl("updateStatus",array("id"=>$data->id,"status"=>"' . ModulesEnabled::STATUS_ENABLED . '"))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_MODULES_ENABLED . '","' . Acl::ACTION_UPDATE . '") && ($data->status==="' . ModulesEnabled::STATUS_DISABLED . '")?true:false',
                    'url_attribute' => 'data-ajax-url',
                    'options' => array(
                        'data-confirm' => false,
                        'data-grid_id' => $grid_id,
                        'class' => 'btn btn-sm btn-success my-update-grid',
                        'title' => Lang::t('Enable this module'),
                    ),
                ),
                'disable' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-remove bigger-130"></i> ' . Lang::t('Disable'),
                    'url' => 'Yii::app()->controller->createUrl("updateStatus",array("id"=>$data->id,"status"=>"' . ModulesEnabled::STATUS_DISABLED . '"))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_MODULES_ENABLED . '","' . Acl::ACTION_UPDATE . '") && ($data->status==="' . ModulesEnabled::STATUS_ENABLED . '")?true:false',
                    'url_attribute' => 'data-ajax-url',
                    'options' => array(
                        'data-confirm' => false,
                        'data-grid_id' => $grid_id,
                        'class' => 'btn btn-sm btn-danger my-update-grid',
                        'title' => Lang::t('Disable this module'),
                    ),
                ),
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil bigger-130"></i> ' . Lang::t(Constants::LABEL_UPDATE),
                    'url' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_MODULES_ENABLED . '","' . Acl::ACTION_UPDATE . '")?true:false',
                    'options' => array(
                        'class' => 'btn btn-sm btn-info',
                        'title' => Lang::t(Constants::LABEL_UPDATE),
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-trash bigger-130"></i> ' . Lang::t(Constants::LABEL_DELETE),
                    'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->id))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_MODULES_ENABLED . '", "' . Acl::ACTION_DELETE . '")?true:false',
                    'url_attribute' => 'data-ajax-url',
                    'options' => array(
                        'data-grid_id' => $grid_id,
                        'data-confirm' => Lang::t('DELETE_CONFIRM'),
                        'class' => 'btn btn-sm btn-danger delete my-update-grid',
                        'title' => Lang::t(Constants::LABEL_DELETE),
                    ),
                ),
            )
        ),
    ),
));
?>