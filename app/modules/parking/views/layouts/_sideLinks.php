<?php if ($this->showLink(UserResources::RES_PARKING)): ?>
        <li  class="<?php echo $this->activeMenu === ParkingModuleController::MENU_PARKING ? 'active' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl(ModulesEnabled::MOD_PARKING . '/default/index') ?>">
                        <i class="icon-truck"></i>
                        <span class="menu-text"> <?php echo Lang::t('Parking Fees') ?></span>
                </a>
        </li>
<?php endif; ?>

