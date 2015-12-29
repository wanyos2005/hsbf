<?php
$grid_id = 'inbox-listview';
$model_class_name = $model->getClassName();
?>
<div class="message-container">
        <div id="id-message-item-navbar" class="message-navbar align-center clearfix">
                <div class="message-bar">
                        <div class="message-infobar" id="id-message-infobar">
                                <span class="blue bigger-150"><?php echo CHtml::encode($this->pageTitle); ?></span>
                        </div>
                </div>
                <div>
                        <div class="messagebar-item-left">
                                <a href="<?php echo $this->createUrl('inbox') ?>" class="btn-back-message-list"><i class="icon-arrow-left blue bigger-110 middle"></i><b class="bigger-110 middle">&nbsp;<?php echo Lang::t('Back') ?></b></a>
                        </div>
                        <div class="messagebar-item-right">
                                <span class="text-muted"><?php echo Lang::t('{count} message(s) in this thread', array('{count}' => $model->getThreadCount())) ?></span>
                        </div>
                </div>
        </div>
        <?php
        $this->widget('application.components.widgets.ListView', array(
            'id' => $grid_id,
            'dataProvider' => $searchModel->search(),
            'itemView' => 'msg.views.message._thread_list',
            'viewData' => array('activeModel' => $model),
            'template' => $this->renderPartial('msg.views.message._thread_template', array(), true),
            'itemsHtmlOptions' => array(
                'class' => '',
            ),
            'updateSelector' => '.mylistview_ajax_update a',
            'ajaxUpdate' => 'view-items-listview',
            'afterAjaxUpdate' => 'js:function(id,data) {MyUtils.stopBlockUI(); MyController.Msg.Message.Inbox.init();}',
            'htmlOptions' => array(
                'class' => 'test',
            ),
            'sorterCssClass' => 'inbox-listview-sorter',
        ));
        ?>
</div>
