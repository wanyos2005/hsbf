<?php

$can_delete = Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_DELETE, FALSE);
$can_update = Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_UPDATE, FALSE);
$grid_id = 'help-category-grid';
Yii::app()->clientScript->registerScript('search', "
$('#active-search-form').submit(function(){
	$.fn.yiiGridView.update('" . $grid_id . "', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => $grid_id,
    'dataProvider' => $model->search($this->settings[Constants::KEY_PAGINATION], '`name` asc'),
    'cssFile' => false,
    'itemsCssClass' => 'style2',
    'pagerCssClass' => 'pagination',
    'pager' => array('cssFile' => false, 'header' => ''),
    'summaryText' => Lang::t('summary_text'),
    'columns' => array(
        'id',
        'name',
        'description',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
            'deleteConfirmation' => Lang::t('DELETE_CONFIRM'),
            'htmlOptions' => array(
                'style' => 'width:100px',
                'class' => 'center-align',
            ),
            'buttons' => array(
                'update' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-pencil"></i>',
                    'visible' => '"' . $can_update . '"?true:false',
                    'url' => 'Yii::app()->controller->createUrl("updateHelpCategory",array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-mini btn-info',
                        'title' => 'Update',
                        'onclick' => 'return MyColorBox.showColorbox($(this).attr("href"));',
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-remove"></i>',
                    'visible' => '"' . $can_delete . '"?true:false',
                    'url' => 'Yii::app()->controller->createUrl("deleteHelpCategory",array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-mini btn-danger',
                        'title' => 'Delete'
                    ),
                ),
            )
        ),
    ),
));
?>
