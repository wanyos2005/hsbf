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
            <span class="menu-text"> <?php echo Lang::t('Financial Statements') ?></span>
        </a>
    </li>
<?php endif; ?>