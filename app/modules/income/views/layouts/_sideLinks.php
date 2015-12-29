<?php if ($this->showLink(UserResources::RES_INCOME)): ?>
    <li  class="<?php echo $this->activeMenu === IncomeModuleController::MENU_INCOME ? 'active' : '' ?>">
        <a href="<?php echo Yii::app()->createUrl('income/default/index') ?>">
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Income') ?></span>
        </a>
    </li>
<?php endif; ?>