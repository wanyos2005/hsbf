<?php
if ($data->owner === MsgMessageCopies::OWNER_SENDER)
        $recipients = $data->getRecipientList();
$latest_thread = $data->getLatestThread();
$date_created = Yii::app()->localtime->toLocalDateTime($latest_thread['date_created']);
?>
<div data-target="<?php echo $this->createUrl('view', array('id' => $latest_thread['id'])) ?>" class="message-item <?php echo!$data->read ? 'message-unread' : '' ?>">
        <label class="inline">
                <input type="checkbox" class="ace" />
                <span class="lbl"></span>
        </label>
        <span class="sender" title="<?php echo $data->owner === MsgMessageCopies::OWNER_RECIPIENT ? CHtml::encode($data->from) : $recipients ?>">
                <?php echo $data->owner === MsgMessageCopies::OWNER_RECIPIENT ? CHtml::encode($data->from) : $recipients ?>
        </span>
        <span class="threads-count light-grey">
                <?php if (($thread_count = $data->getThreadCount()) > 1): ?>
                        (<?php echo $thread_count ?>)
                <?php else: ?>
                        &nbsp;
                <?php endif; ?>
        </span>
        <span class="time"><time class="timeago" datetime="<?php echo $date_created ?>"><?php echo Common::formatDate($date_created) ?></time></span>
        <span class="summary">
                <?php if ($latest_thread['owner'] === MsgMessageCopies::OWNER_RECIPIENT): ?>
                        <span class="message-flags"><i class="icon-mail-reply light-grey"></i></span>
                <?php else: ?>
                        <span class="message-flags"><i class="icon-mail-forward light-grey"></i></span>
                <?php endif; ?>
                <span class="text">
                        <?php echo CHtml::encode($data->topic) ?>
                </span>
                <span class="message text-muted">
                        <?php echo CHtml::encode($latest_thread['message']) ?>
                </span>
        </span>
</div>
