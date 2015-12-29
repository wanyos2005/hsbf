<li class="green" id="topbar_messages">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="topbar_messages_anchor" data-ajax-url="<?php echo Yii::app()->createUrl('msg/message/getNotifications') ?>" data-unread="">
                <i class="icon-envelope icon-animated-vertical"></i>
                <span class="badge badge-danger unread hidden"></span>
        </a>
        <ul id="topbar_messages_list" class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">

        </ul>
</li>
<?php
Yii::app()->clientScript->registerScript('msg.message.notification', "MyController.Msg.Message.init();");
?>