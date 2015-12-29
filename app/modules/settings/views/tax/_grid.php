<?php
$grid_id = 'settings-tax-grid-' . $model->category_id;
$search_form_id = $grid_id . '-active-search-form';
?>
<!--grid header-->
<div class="row grid-view-header">
        <div class="col-sm-12">
                <div class="btn-group">
                        <?php if ($this->showLink($this->resource, Acl::ACTION_CREATE)): ?><a class="btn btn-sm show-colorbox" href="<?php echo $this->createUrl('create', array('cat_id' => $model->category_id)) ?>"><i class="icon-plus-sign"></i> <?php echo Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel) ?></a><?php endif; ?>
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
        'name',
        'rate',
        array(
            'class' => 'ButtonColumn',
            'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            'htmlOptions' => array('class' => 'text-center', 'style' => 'width: 100px;'),
            'buttons' => array(
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_TAXES . '","' . Acl::ACTION_UPDATE . '")?true:false',
                    'options' => array(
                        'class' => 'green',
                        'title' => Lang::t(Constants::LABEL_UPDATE),
                        'onclick' => 'return MyUtils.showColorbox(this.href)',
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-trash bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_TAXES . '", "' . Acl::ACTION_DELETE . '")?true:false',
                    'options' => array(
                        'class' => 'delete red',
                        'title' => Lang::t(Constants::LABEL_DELETE),
                    ),
                ),
            )
        ),
    ),
));
?>