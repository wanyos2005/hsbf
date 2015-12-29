<?php
$total_unread = MsgMessageCopies::model()->getTotals('user_id=:t1 and `read`=:t2', array(':t1' => Yii::app()->user->id, ':t2' => 0));
$grid_id = 'inbox-listview';
$model_class_name = $model->getClassName();
?>
<div class="message-container">
        <div id="id-message-list-navbar" class="message-navbar align-center clearfix">
                <div class="message-bar">
                        <div class="message-infobar" id="id-message-infobar">
                                <span class="blue bigger-150"><?php echo Lang::t('Inbox'); ?></span>
                                <span class="grey bigger-110">(<?php echo number_format($total_unread) ?> <?php echo Lang::t('unread messages') ?>)</span>
                        </div>
                        <div class="message-toolbar hide">
                                <div class="inline position-relative align-left">
                                        <a href="#" class="btn-message btn btn-xs dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-ok-circle bigger-110"></i>
                                                <span class="bigger-110"><?php echo Lang::t('Mark as') ?></span>
                                                <i class="icon-caret-down icon-on-right"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125" id="_mark_as_">
                                                <li><a href="#" data-ajax-url="<?php echo $this->createUrl('markThreadAs', array('key' => 'read', 'val' => 1)) ?>"><?php echo Lang::t('Read') ?></a></li>
                                                <li><a href="#" data-ajax-url="<?php echo $this->createUrl('markThreadAs', array('key' => 'read', 'val' => 0)) ?>"><?php echo Lang::t('Unread') ?></a></li>
                                        </ul>
                                </div>
                                <button data-ajax-url="<?php echo $this->createUrl('deleteThreads') ?>" class="btn btn-xs btn-message" id="_delete_selected">
                                        <i class="icon-trash bigger-125"></i>
                                        <span class="bigger-110"><?php echo Lang::t('Delete') ?></span>
                                </button>
                        </div>
                </div>
                <div>
                        <div class="messagebar-item-left">
                                <label class="inline middle">
                                        <input type="checkbox" id="id-toggle-all" class="ace" />
                                        <span class="lbl"></span>
                                </label>
                                &nbsp;
                                <div class="inline position-relative">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                                <i class="icon-caret-down bigger-125 middle"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-lighter dropdown-100">
                                                <li><a id="id-select-message-all" href="#"><?php echo Lang::t('All') ?></a></li>
                                                <li><a id="id-select-message-unread" href="#"><?php echo Lang::t('Unread') ?></a></li>
                                                <li><a id="id-select-message-read" href="#"><?php echo Lang::t('Read') ?></a></li>
                                        </ul>
                                </div>
                        </div>
                        <div class="messagebar-item-right">
                                <div class="inline position-relative">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Lang::t('Sort') ?> &nbsp;<i class="icon-caret-down bigger-125"></i></a>
                                        <ul class="dropdown-menu dropdown-lighter pull-right dropdown-100 inbox-listview-sorter">
                                                <li><a href="<?php echo Yii::app()->createUrl($this->route, array_merge($this->actionParams, array('sort' => 'date_created.desc', $model_class_name => null))); ?>" id="_sort_by_newest"><i class="icon-ok green"></i><?php echo Lang::t('Newest') ?></a></li>
                                                <li><a href="<?php echo Yii::app()->createUrl($this->route, array_merge($this->actionParams, array('sort' => 'date_created', $model_class_name => null))); ?>" id="_sort_by_oldest"><i class="icon-ok invisible"></i><?php echo Lang::t('Oldest') ?></a></li>
                                                <li><a href="<?php echo Yii::app()->createUrl($this->route, array_merge($this->actionParams, array('sort' => 'from', $model_class_name => null))); ?>" id="_sort_by_from" ><i class="icon-ok invisible"></i><?php echo Lang::t('From') ?></a></li>
                                                <li><a href="<?php echo Yii::app()->createUrl($this->route, array_merge($this->actionParams, array('sort' => 'topic', $model_class_name => null))); ?>" id="_sort_by_subject"><i class="icon-ok invisible"></i><?php echo Lang::t('Subject') ?></a></li>
                                        </ul>
                                </div>
                        </div>
                        <div class="nav-search minimized">
                                <?php
                                $this->beginWidget('ext.activeSearch.AjaxSearch', array(
                                    'gridID' => $grid_id,
                                    'formID' => $grid_id . '_search_form',
                                    'model' => $model,
                                    'grid_type' => 'clistview',
                                    'search_trigger' => 'blur',
                                    'action' => Yii::app()->createUrl($this->route, $this->actionParams),
                                    'formHtmlOptions' => array(
                                        'class' => 'form-search',
                                    ),
                                    'searchFieldHtmlOptions' => array(
                                        'autocomplete' => 'off',
                                        'class' => 'input-small nav-search-input',
                                        'placeholder' => Lang::t('Search inbox ...'),
                                    ),
                                    'search_field_template' => '<span class="input-icon">{{search_field}} <i class="icon-search nav-search-icon"></i></span>',
                                ));
                                ?>
                                <?php $this->endWidget(); ?>
                        </div>
                </div>
        </div>
        <?php
        $this->widget('application.components.widgets.ListView', array(
            'id' => $grid_id,
            'dataProvider' => $model->search(),
            'itemView' => 'msg.views.message._inbox_listview_item',
            'template' => $this->renderPartial('msg.views.message._inbox_listview_template', array(), true),
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
