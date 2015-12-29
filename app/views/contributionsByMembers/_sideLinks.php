<?php
$id = Yii::app()->user->id;

$officio = Maofficio::model()->officio();
$open = isset($_REQUEST['active']) && ($_REQUEST['active'] == 'completereg' || $_REQUEST['active'] == 'bikha' || $_REQUEST['active'] == 'kula' || $_REQUEST['active'] == 'sttmt' || $_REQUEST['active'] == 'csbk' || $_REQUEST['active'] == 'blst' || $_REQUEST['active'] == 'trbl' || $_REQUEST['active'] == 'lgbk' || $_REQUEST['active'] == 'papulo' || $_REQUEST['active'] == 'erisiti' || $_REQUEST['active'] == 'sava' || $_REQUEST['active'] == 'viandu' || $_REQUEST['active'] == 'towako' || $_REQUEST['active'] == 'towachi' || $_REQUEST['active'] == 'rura' || $_REQUEST['active'] == 'rurwa');
?>

<li class="<?php echo $open == true ? 'active open' : '' ?>">
    <a href="<?php echo Yii::app()->createUrl('users/default/index') ?>" class="dropdown-toggle">
        <i class="icon-user"></i>
        <span class='menu-text'> <?php echo Lang::t('Members') ?></span>
        <b class="arrow icon-angle-down"></b>
    </a>
    <ul class="submenu">


        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.modules.users.views.default._sideLinks_reg') ?></li>


        <?php if (!empty($officio)): ?>
            <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.views.contributionsByMembers._sideLinks1') ?></li>
        <?php endif; ?>
            
            
        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.views.expenditures._sideLinks') ?></li>    


        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.views.contributionsByMembers._sideLinks2') ?></li>

        
        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.views.loanApplications._sideLinks') ?></li>


        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"> <?php $this->renderPartial('application.views.cashWithdrawals._sideLinks') ?></li>


        <li class="<?php echo $this->activeMenu === '' ? 'active' : '' ?>"><?php $this->renderPartial('application.views.memberWithdrawal._sideLinks') ?></li>

        <?php if ($this->showLink(UserResources::RES_USER_LEVELS)): ?>
            <li class="<?php echo $this->activeMenu === UsersModuleController::MENU_USER_LEVELS ? 'active' : ''; ?>">
                <a href="<?php echo Yii::app()->createUrl('users/userLevels/index'); ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Lang::t('User Levels'); ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</li>


