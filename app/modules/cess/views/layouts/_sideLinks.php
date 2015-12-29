<?php if ($this->showLink(UserResources::RES_CESS)): ?>
        <li  class="<?php echo $this->activeMenu === CessModuleController::MENU_CESS ? 'active' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl(ModulesEnabled::MOD_CESS . '/default/index') ?>">
                        <i class="icon-money"></i>
                        <span class="menu-text"> <?php echo Lang::t('Cess') ?></span>
                </a>
        </li>
<?php endif; ?>

