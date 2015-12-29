<h4 class="lighter">Email Settings</h4>
<div class="widget-toolbar no-border">
        <ul class="nav nav-tabs my-nav">
                <li class="<?php echo $this->activeTab === 1 ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/default/email') ?>"><?php echo Lang::t('Email Settings') ?></a></li>
                <li class="<?php echo $this->activeTab === 2 ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/emailTemplate/index') ?>"><?php echo Lang::t('Email Templates') ?></a></li>
        </ul>
</div>
