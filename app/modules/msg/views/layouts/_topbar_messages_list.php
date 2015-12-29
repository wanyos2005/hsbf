<li class="dropdown-header"><i class="icon-envelope-alt"></i><span><?php echo number_format($count); ?></span> <?php echo Lang::t('Unread Messages') ?></li>
<?php foreach ($data as $row): ?>
        <?php $localtime = Yii::app()->localtime->toLocalDateTime($row['date_created'], 'Y-m-d H:i:s'); ?>
        <li>
                <a href="<?php echo Yii::app()->createUrl('msg/message/view', array('id' => $row['id'])) ?>">
                        <?php echo CHtml::image(MyYiiUtils::getThumbSrc(Users::model()->getProfileImagePath($row['from_user_id']), array('resize' => array('width' => 50, 'height' => null)), 'http://placehold.it/50x50'), CHtml::encode($row['from']), array('class' => 'msg-photo', 'style' => 'max-width:50px;')); ?>
                        <span class="msg-body">
                                <span class="msg-title">
                                        <span class="blue"><?php echo CHtml::encode($row['from']) ?></span><br/>
                                        <?php echo MyYiiUtils::myShortenedString($row['message'], 20, " ...", 20); ?>
                                </span>
                                <span class="msg-time">
                                        <i class="icon-time"></i>
                                        <time class="timeago" datetime="<?php echo $localtime ?>"><?php echo Common::formatDate($localtime); ?></time>
                                </span>
                        </span>
                </a>
        </li>
<?php endforeach; ?>
<li><a href="<?php echo Yii::app()->createUrl('msg/message/inbox') ?>"><?php echo Lang::t('See all messages') ?> <i class="icon-arrow-right"></i></a></li>
