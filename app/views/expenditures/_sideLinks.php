<?php if (Maofficio::model()->officio() == 'treasurer'): ?>
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'kula' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'kula'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/create', array('active' => 'kula')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Cash Transactions') ?></span>
        </a>
    </li>
    
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'sttmt' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'sttmt'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/paymentJournals', array('active' => 'sttmt')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Journals') ?></span>
        </a>
    </li>
    
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'csbk' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'csbk'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/cashBook', array('active' => 'csbk')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Cash Book') ?></span>
        </a>
    </li>
    
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'blst' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'blst'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/balanceSheet', array('active' => 'blst')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Balance Sheet') ?></span>
        </a>
    </li>
    
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'lgbk' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'lgbk'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/ledgerBook', array('active' => 'lgbk')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Ledger Books') ?></span>
        </a>
    </li>
    
    <li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'trbl' ? 'active' : '' ?>">
        <a
        <?php
        if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'trbl'):
            ?>

                <?php
            else:
                ?>
                href="<?php echo Yii::app()->createUrl('/expenditures/trialBalance', array('active' => 'trbl')); ?>"
            <?php
            endif;
            ?>
            >
            <i class="icon-suitcase"></i>
            <span class="menu-text"> <?php echo Lang::t('Trial Balance') ?></span>
        </a>
    </li>
<?php endif; ?>