<?php if ($this->showLink(UserResources::RES_LAND_RATES)): ?>
        <li  class="<?php echo $this->activeMenu === LandratesModuleController::MENU_LAND_RATES ? 'active' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl(ModulesEnabled::MOD_LAND_RATES . '/default/index') ?>">
                        <i class="icon-money"></i>
                        <span class="menu-text"> <?php echo Lang::t('Land rates') ?></span>
                </a>
        </li>
<?php endif; ?>

