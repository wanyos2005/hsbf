<?php
$grid_id = 'users-grid';
$search_form_id = $grid_id . '-active-search-form';
?>
<!--grid header-->
<div class="row grid-view-header">
        <div class="col-sm-6">
                <div class="btn-group">
                        <?php if ($this->showLink($this->resource, Acl::ACTION_CREATE)): ?><a class="btn btn-sm" href="<?php echo $this->createUrl('create', $this->actionParams) ?>"><i class="icon-plus-sign"></i> <?php echo Lang::t('Add ' . $this->resourceLabel) ?></a><?php endif; ?>
                </div>
        </div>
        <div class="col-sm-6">
                <div class="dataTables_filter">
                        <?php
                        $this->beginWidget('ext.activeSearch.AjaxSearch', array(
                            'gridID' => $grid_id,
                            'formID' => $search_form_id,
                            'model' => $model,
                            'action' => Yii::app()->createUrl($this->route, $this->actionParams),
                        ));
                        ?>
                        <?php $this->endWidget(); ?>
                </div>
        </div>
</div>
<?php
$this->widget('application.components.widgets.GridView', array(
    'id' => $grid_id,
    'dataProvider' => $model->search(),
    'enablePagination' => $model->enablePagination,
    'enableSummary' => $model->enableSummary,
    'rowCssClassExpression' => '$data->status==="' . Users::STATUS_BLOCKED . '"?"bg-danger":""',
    'columns' => array(
        'id',
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->username),Yii::app()->controller->createUrl("view",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'name',
        ),
        array(
            'name' => 'email',
        ),
        array(
            'name' => 'date_created',
            'value' => 'MyYiiUtils::formatDate($data->date_created)',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => 'CHtml::tag("span", array("class"=>$data->status==="' . Users::STATUS_ACTIVE . '"?"badge badge-success":"badge badge-danger"), $data->status)',
        ),
        array(
            'name' => 'user_level',
            'visible' => empty($model->store_id),
        ),
        array(
            'class' => 'ButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-eye-open bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))',
                    'options' => array(
                        'class' => 'blue',
                        'title' => Lang::t('View details'),
                    ),
                ),
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey))',
                    'visible' => '$data->canBeModified($this->grid->owner,"' . Acl::ACTION_UPDATE . '")',
                    'options' => array(
                        'class' => 'green',
                        'title' => Lang::t('Edit'),
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-trash bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
                    'visible' => '$data->canBeModified($this->grid->owner,"' . Acl::ACTION_DELETE . '")',
                    'options' => array(
                        'class' => 'delete red',
                        'title' => Lang::t('Delete'),
                    ),
                ),
            )
        ),
    ),
));
?>
