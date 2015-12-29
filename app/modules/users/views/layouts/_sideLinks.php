<?php if ($this->showLink(UserResources::RES_USER_ADMIN)): ?>
        <li class="<?php echo $this->getModuleName() === 'users' ? 'active open' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl('users/default/index') ?>" class="dropdown-toggle">
                        <i class="icon-user"></i>
                        <span class="menu-text"> <?php echo Lang::t('Users') ?></span>
                        <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                        <?php if ($this->showLink(UserResources::RES_USER_ADMIN)): ?>
                                <li class="<?php echo $this->activeMenu === UsersModuleController::MENU_USER_ADMIN ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('users/default/index') ?>"><i class="icon-double-angle-right"></i><?php echo Lang::t('Users') ?></a></li>
                        <?php endif; ?>
                        <?php if ($this->showLink(UserResources::RES_USER_ROLES)): ?>
                                <li class="<?php echo $this->activeMenu === UsersModuleController::MENU_USER_ROLES ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('users/roles/index') ?>"><i class="icon-double-angle-right"></i><?php echo Lang::t('Roles') ?></a></li>
                        <?php endif; ?>
                        <?php if ($this->showLink(UserResources::RES_USER_RESOURCES)): ?>
                                <li class="<?php echo $this->activeMenu === UsersModuleController::MENU_USER_RESOURCES ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('users/resources/index') ?>"><i class="icon-double-angle-right"></i><?php echo Lang::t('Resources') ?></a></li>
                        <?php endif; ?>
                        <?php if ($this->showLink(UserResources::RES_USER_LEVELS)): ?>
                                <li class="<?php echo $this->activeMenu === UsersModuleController::MENU_USER_LEVELS ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('users/userLevels/index') ?>"><i class="icon-double-angle-right"></i><?php echo Lang::t('User Levels') ?></a></li>
                                        <?php endif; ?>
                </ul>
        </li>
<?php endif; ?>

