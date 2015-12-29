<?php
$grid_id = 'settings-units-conversion-grid';
$search_form_id = $grid_id . '-active-search-form';
?>
<!--grid header-->
<div class="row grid-view-header">
        <div class="col-sm-6">
                <div class="btn-group">
                        <?php if ($this->showLink($this->resource, Acl::ACTION_CREATE)): ?><a class="btn btn-sm show-colorbox" href="<?php echo $this->createUrl('createConversion') ?>"><i class="icon-plus-sign"></i> <?php echo Lang::t('Add ' . $this->resourceLabel . ' Conversion') ?></a><?php endif; ?>
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
    'columns' => array(
        array(
            'name' => 'from_unit_id',
            'value' => 'SettingsUnitsOfMeasure::model()->get($data->from_unit_id,"name")',
        ),
        array(
            'name' => 'to_unit_id',
            'value' => 'SettingsUnitsOfMeasure::model()->get($data->to_unit_id,"name")',
        ),
        'value',
        array(
            'class' => 'ButtonColumn',
            'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            'htmlOptions' => array('class' => 'text-center', 'style' => 'width: 100px;'),
            'buttons' => array(
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("updateConversion",array("id"=>$data->primaryKey))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_UNITS_OF_MEASURE . '","' . Acl::ACTION_UPDATE . '")?true:false',
                    'options' => array(
                        'class' => 'green',
                        'title' => 'Edit',
                        'onclick' => 'return MyUtils.showColorbox(this.href)',
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-trash bigger-130"></i>',
                    'url' => 'Yii::app()->controller->createUrl("deleteConversion",array("id"=>$data->primaryKey))',
                    'visible' => '$this->grid->owner->showLink("' . UserResources::RES_SETTINGS_UNITS_OF_MEASURE . '", "' . Acl::ACTION_DELETE . '")?true:false',
                    'options' => array(
                        'class' => 'delete red',
                        'title' => 'Delete',
                    ),
                ),
            )
        ),
    ),
));
?>