<ul class="nav nav-tabs padding-18 profile-tabs">
        <li class="<?php echo $this->activeTab === 1 ? 'active' : '' ?>"><a href="<?php echo $this->createUrl('users/user/view', array('id' => $model->id)) ?>"><i class="blue icon-user bigger-120"></i> <?php echo Lang::t('Profile') ?></a></li>
</ul>
