<?php

$can_delete = Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_DELETE, FALSE);
$can_update = Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_UPDATE, FALSE);
$grid_id = 'help-topic-grid';
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
    'dataProvider' => $model->search($this->settings[Constants::KEY_PAGINATION], '`category_id` asc,`topic` asc'),
    'cssFile' => false,
    'itemsCssClass' => 'style2',
    'pagerCssClass' => 'pagination',
    'pager' => array('cssFile' => false, 'header' => ''),
    'summaryText' => Lang::t('summary_text'),
    'columns' => array(
        'id',
        array(
            'name' => 'topic',
            'type' => 'raw',
            'value' => 'CHtml::link($data->topic,Yii::app()->controller->createUrl("update",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'category_id',
            'value' => 'HelpCategory::model()->get($data->category_id,"name")',
        ),
        array(
            'name' => 'date_created',
            'value' => 'Common::formatDate($data->date_created)',
        ),
        array(
            'name' => 'last_modified',
            'value' => 'Common::formatDate($data->last_modified)',
        ),
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
                    'options' => array(
                        'class' => 'btn btn-mini btn-info',
                        'title' => 'Edit',
                    ),
                ),
                'delete' => array(
                    'imageUrl' => false,
                    'label' => '<i class="icon-remove"></i>',
                    'visible' => '"' . $can_delete . '"?true:false',
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