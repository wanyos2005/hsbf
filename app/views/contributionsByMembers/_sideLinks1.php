<?php $id = Yii::app()->user->id; ?>

<li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'bikha' ? 'active' : '' ?>">
    <a
    <?php
    if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'bikha'):
        ?>

            <?php
        else:
            ?>
            href="<?php echo Yii::app()->createUrl('/contributionsByMembers/create', array('active' => 'bikha')); ?>"
        <?php
        endif;
        ?>
        >
        <i class="icon-suitcase"></i>
        <span class="menu-text"> <?php echo Lang::t('Make Payment') ?></span>
    </a>
</li>