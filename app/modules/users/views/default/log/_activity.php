<div class="my-colobox" style="min-width: 500px">
        <?php
        $can_delete = $this->showLink($this->resource, Acl::ACTION_DELETE);
        $grid_id = 'user-activity-log-grid';
        $search_form_id = $grid_id . '-active-search-form';
        ?>
        <div class="page-header">
                <h1><?php echo CHtml::encode($this->pageTitle) ?></h1>
        </div>
        <div class="alert hidden" id="my-colorbox-notif"></div>
        <!--grid header-->
        <div class="row grid-view-header">
                <div class="col-lg-6">
                        <div class="btn-group">
                                <?php if ($can_delete): ?><button class="btn btn-sm grid_delete_multiple" type="button" data-ajax-url="<?php echo $this->createUrl('deleteLog', array('t' => $this::LOG_ACTIVITY)) ?>" data-grid_id="<?php echo $grid_id; ?>"><i class="icon-trash"></i>&nbsp;<?php echo Lang::t('Delete selected') ?></button><?php endif ?>
                        </div>
                </div>
                <div class="col-lg-6">
                        <div class="dataTables_filter">
                                <?php
                                $this->beginWidget('ext.activeSearch.AjaxSearch', array(
                                    'gridID' => $grid_id,
                                    'formID' => $search_form_id,
                                    'model' => $model,
                                    'action' => Yii::app()->createUrl($this->route, $this->actionParams),
                                    'searchFieldHtmlOptions' => array(
                                        'placeholder' => 'yyyy-mm-dd',
                                    ),
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
            'selectableRows' => 2,
            'pager_max_buttons' => 5,
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'header' => 'Enabled',
                    'visible' => $can_delete ? true : false,
                    'htmlOptions' => array(
                        'width' => 30,
                    )
                ),
                array(
                    'name' => 'date_created',
                    'value' => 'Common::formatDate($data->date_created,"Y-m-d g:i a")',
                ),
                'ip',
                array(
                    'name' => 'activity',
                    'value' => 'MyYiiUtils::myShortenedString($data->activity,400," ...",100)',
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
</div>