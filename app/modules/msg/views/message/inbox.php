<div class="row">
        <div class="col-xs-12">
                <?php $this->renderPartial('_inbox', array('model' => $model)); ?>
        </div><!-- /.col -->
</div><!-- /.row -->
<?php
Yii::app()->clientScript->registerScript('msg.message.inbox', "MyController.Msg.Message.Inbox.init();");
?>