<?php if ($this->showLink(UserResources::RES_DEPT)): ?>
    <li  class="<?php echo $this->activeMenu === DeptModuleController::MENU_DEPT ? 'active' : '' ?>">
        <a href="<?php echo Yii::app()->createUrl('dept/default/index') ?>">
            <i class="icon-building"></i>
            <span class="menu-text"> <?php echo Lang::t('Departments') ?></span>
        </a>
    </li>
<?php endif; ?>

