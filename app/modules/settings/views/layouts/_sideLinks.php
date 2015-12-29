<li class="<?php echo $this->getModuleName() === 'settings' ? 'active open' : '' ?>">
        <a href="<?php echo Yii::app()->createUrl('settings/default/index') ?>" class="dropdown-toggle">
                <i class="icon-wrench"></i>
                <span class="menu-text"><?php echo Lang::t('Settings') ?></span>
                <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
                <?php if ($this->showLink(UserResources::RES_SETTINGS_GENERAL)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_GENERAL ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/default/index') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('General Settings') ?></a></li>
                <?php endif; ?>
                <?php if ($this->showLink(UserResources::RES_SETTINGS_EMAIL)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_EMAIL ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/default/email') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Email Settings') ?></a></li>
                <?php endif; ?>
                <?php if ($this->showLink(UserResources::RES_SETTINGS_TAXES)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_TAXES ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/tax/index') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Tax Settings') ?></a></li>
                <?php endif; ?>

                <?php if ($this->showLink(UserResources::RES_SETTINGS_RUNTIME)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_RUNTIME ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/default/runtime') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Runtime Logs') ?></a></li>
                <?php endif; ?>
                <?php if ($this->showLink(UserResources::RES_SETTINGS_CRON)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_CRON ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/cronTask/index') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Cron Settings') ?></a></li>
                <?php endif; ?>
                <?php if ($this->showLink(UserResources::RES_SETTINGS_UNITS_OF_MEASURE)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_SETTINGS_UNITS_OF_MEASURE ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/units/index') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Units of Measure') ?></a></li>
                <?php endif; ?>
                <?php if ($this->showLink(UserResources::RES_MODULES_ENABLED)): ?>
                        <li class="<?php echo $this->activeMenu === SettingsModuleController::MENU_MODULES_ENABLED ? 'active' : '' ?>"><a href="<?php echo Yii::app()->createUrl('settings/modules/index') ?>"><i class="icon-double-angle-right"></i> <?php echo Lang::t('Manage Modules') ?></a></li>
                        <?php endif; ?>
        </ul>
</li>
