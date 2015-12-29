<li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'oundi' ? 'active' : '' ?>">
    <a
    <?php
    if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'oundi'):
        ?>

            <?php
        else:
            ?>
            href="<?php echo Yii::app()->createUrl('/users/default/regiterAmember', array('active' => 'oundi')); ?>"
        <?php
        endif;
        ?>
        >
        <i class="icon-suitcase"></i>
        <span class="menu-text"> <?php echo Lang::t('Register A Member') ?></span>
    </a>
</li>
