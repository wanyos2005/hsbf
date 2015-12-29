<?php $id = Yii::app()->user->id; ?>

<?php
if (Savings::model()->memberCanWithraw($id)):
    ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'towako' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'towako'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/cashWithdrawals/create', array('active' => 'towako')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Withdraw Savings') ?></span>
        </a>
    </li>
<?php endif; ?>


<?php
$currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
if (!empty($currentTreasurer) && $currentTreasurer->member == $id) {
    $model = CashWithdrawals::model()->find("effected_by_treasurer!='Yes' && received_by_secretary='Yes' && secretary_date IS NOT NULL && approved_by_chairman='Yes' && chairman_date IS NOT NULL");
} else {
    $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
    if (!empty($currentSecretary) && $currentSecretary->member == $id)
        $model = CashWithdrawals::model()->find("approved_by_chairman='Pending' && chairman_date IS NULL && effected_by_treasurer='Pending' && treasurer_date IS NULL");
    else {
        $currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
        if (!empty($currentChairman) && $currentChairman->member == $id)
            $model = CashWithdrawals::model()->find("received_by_secretary='Yes' && secretary_date IS NOT NULL && effected_by_treasurer='Pending' && treasurer_date IS NULL");
    }
}

if (!empty($model)):
    ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'towachi' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'towachi'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/cashWithdrawals/approveWithdrawals', array('active' => 'towachi')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Savings Withdrawals') ?></span>
        </a>
    </li>
<?php endif; ?>