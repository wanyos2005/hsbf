<li class="<?php echo isset($_REQUEST['active']) && $_REQUEST['active'] == 'completereg' ? 'active' : '' ?>">
    <a
    <?php
    if (isset($_REQUEST['active']) && $_REQUEST['active'] == 'completereg'):
        ?>

            <?php
        else:
            ?>
            href="<?php echo Yii::app()->createUrl('/users/default/view', array('active' => 'completereg')); ?>"
        <?php
        endif;
        ?>
        >
        <i class="icon-thumbs-up-alt"></i>
        <span class="menu-text"> <?php echo Lang::t('Complete registration') ?></span>
    </a>
</li>
