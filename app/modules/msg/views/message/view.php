<?php $this->renderPartial('_view', array('searchModel' => $searchModel, 'model' => $model)) ?>
<?php

Yii::app()->clientScript->registerScript('msg.message.inbox', "MyController.Msg.Message.Inbox.init();");
?>