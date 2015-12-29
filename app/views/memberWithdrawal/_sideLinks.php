<?php
$id = Yii::app()->user->id;
$officio = Maofficio::model()->officio();
?>

<?php if (empty($officio)): ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'rura' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'rura'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/memberWithdrawal/create', array('active' => 'rura')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Membership') ?></span>
        </a>
    </li>
<?php endif; ?>

<?php
$currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
if (!empty($currentChairman) && $currentChairman->member == $id) {
    $model = MemberWithdrawal::model()->find("status='Pending' && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && forwarded_by_treasurer!='Pending' && treasurer_date IS NOT NULL");
} else {
    $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
    if (!empty($currentSecretary) && $currentSecretary->member == $id)
        $model = MemberWithdrawal::model()->find("status='Pending' && forwarded_by_treasurer='Pending' && treasurer_date IS NULL && approved_by_chairman='Pending' && chairman_date IS NULL");
    else {
        $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
        if (!empty($currentTreasurer) && $currentTreasurer->member == $id)
            $model = MemberWithdrawal::model()->find("status='Pending' && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && approved_by_chairman='Pending' && chairman_date IS NULL");
    }
}

if (!empty($model)):
    ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'rurwa' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'rurwa'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/memberWithdrawal/memberWithdrawals', array('active' => 'rurwa')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Membership Withdrawals') ?></span>
        </a>
    </li>
<?php endif; ?>