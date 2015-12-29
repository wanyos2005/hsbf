<?php $id = Yii::app()->user->id; ?>

<?php
$totalContributions = ContributionsByMembers::model()->netTotalMemberContribution($id, date('Y') . '-' . date('m') . '-' . date('d'));
if ($totalContributions > 0):
    ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'sava' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'sava'):
            ?>

                <?php
            else:
                ?>
                href="<?php
                echo Yii::app()->createUrl('/loanApplications/myPendingLoanApplications', // '/loanApplications/create',
                        array('active' => 'sava'));
                ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Apply For A Loan') ?></span>
        </a>
    </li>
<?php endif; ?>


<?php
$currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
if (!empty($currentChairman) && $currentChairman->member == $id) {
    $model = LoanApplications::model()->find("witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && forwarded_by_treasurer!='Pending' && treasurer_date IS NOT NULL && closed!='Yes' && close_date IS NULL");
} else {
    $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
    if (!empty($currentSecretary) && $currentSecretary->member == $id)
        $model = LoanApplications::model()->find("witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_treasurer='Pending' && treasurer_date IS NULL && approved_by_chairman='Pending' && chairman_date IS NULL && closed!='Yes' && close_date IS NULL");
    else {
        $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
        if (!empty($currentTreasurer) && $currentTreasurer->member == $id)
            $model = LoanApplications::model()->find("witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && approved_by_chairman='Pending' && chairman_date IS NULL && closed!='Yes' && close_date IS NULL");
    }
}

if (!empty($model)):
    ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'viandu' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'viandu'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/loanApplications/loanApplications', array('active' => 'viandu')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Loan Applications') ?></span>
        </a>
    </li>
<?php endif; ?>