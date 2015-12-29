<?php $id = Yii::app()->user->id; ?>

<?php
$true = false;
foreach (ContributionTypes::model()->findAll('id>1') as $type)
    if ($type->primaryKey == 4)
        $true = $true || LoanApplications::model()->memberHasALoan($id);
    else
        $true = $true || ContributionsByMembers::model()->memberHasAContribution($id, $type->primaryKey);
?>

<?php if ($true): ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'papulo' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'papulo'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/contributionsByMembers/memberStatementsOfAccounts', array('active' => 'papulo')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Statements Of Accounts') ?></span>
        </a>
    </li>
<?php endif; ?>