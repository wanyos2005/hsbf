<li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <?php echo CHtml::image(MyYiiUtils::getThumbSrc(Person::model()->getProfileImagePath(Yii::app()->user->id), array('resize' => array('width' => 40, 'height' => 40)), 'http://placehold.it/40x40'), 'Profile Photo', array('class' => 'nav-user-photo')); ?>
                <span class="user-info"><small><?php echo Lang::t('Welcome') ?>,</small> <?php echo Yii::app()->user->name; ?></span><i class="icon-caret-down"></i>
        </a>
        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li><a href="<?php echo Yii::app()->createUrl('users/default/view') ?>"><i class="icon-user"></i> <?php echo Lang::t('Profile') ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('users/default/view', array('action' => Users::ACTION_CHANGE_PASSWORD)) ?>"><i class="icon-lock"></i> <?php echo Lang::t('Change Password') ?></a></li>
                <li class="divider"></li>
                <li><a href="<?php echo Yii::app()->createUrl('auth/default/logout') ?>"><i class="icon-off"></i> <?php echo Lang::t('Logout') ?></a></li>
        </ul>
</li>