<ul class="nav nav-tabs padding-18 profile-tabs">
        <li class="<?php echo $this->activeTab === 1 ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('dept/default/view', array('id' => $model->id)) ?>"><i class="blue icon-dashboard bigger-120"></i> <?php echo Lang::t('Dashboard') ?></a></li>
</ul>