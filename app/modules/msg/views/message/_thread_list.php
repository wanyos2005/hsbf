<?php
$user = Users::model()->loadModel($data->from_user_id);
$avator = CHtml::image(MyYiiUtils::getThumbSrc($user->getProfileImagePath(), array('resize' => array('width' => 32, 'height' => null))), '', array('class' => 'middle', 'style' => 'width:32px'));
?>
<div class="thread-list<?php
echo (!$data->read) ? ' unread' : '';
echo ($activeModel->id == $data->id) ? ' active' : ''
?>" data-mark-as-url="<?php echo $this->createUrl('markInboxAs', array('id' => $data->id, 'key' => 'read', 'val' => 1)) ?>">
        <div class="message-header clearfix">
                <div class="pull-left">
                        <?php echo $this->showLink(Users::USER_RESOURCE_PREFIX . $user->user_level) ? CHtml::link($avator, Yii::app()->createUrl('users/user/view', array('id' => $user->id)), array('class' => '')) : $avator ?>
                        &nbsp;
                        <?php echo CHtml::link($user->id !== Yii::app()->user->id ? CHtml::encode($user->name) : Lang::t('Me'), $this->createUrl('view', array('id' => $data->id)), array('class' => 'sender')) ?>
                        &nbsp;
                        <i class="icon-time bigger-110 orange middle"></i>
                        <span class="time"><abbr title="<?php echo Common::formatDate($data->date_created) ?>"><time class="timeago" datetime="<?php echo $data->date_created; ?>"><?php echo Common::formatDate($data->date_created) ?></time></abbr></span>
                </div>

                <div class="action-buttons pull-right">
                        <a href="#">
                                <i class="icon-reply green icon-only bigger-130"></i>
                        </a>
                        <a href="#">
                                <i class="icon-trash red icon-only bigger-130"></i>
                        </a>
                </div>
        </div>
        <div class="message-body">
                <?php echo CHtml::encode($data->message) ?>
        </div>
        <div class="hr hr-double"></div>
</div>
