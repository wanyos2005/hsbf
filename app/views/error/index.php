<!DOCTYPE html>
<html lang="en">
        <?php $this->renderPartial('application.views.layouts.partials._head') ?>
        <body style="background: #E9E9E9;">
                <div class="main-container">
                        <div id="error-unit">
                                <i class="icon-frown"></i>
                                <h1><?php echo $error['code']; ?> Something went wrong </h1>
                                <h3 class="uk-animation-slide-right">
                                        <?php if ($error['code'] == 404): ?>
                                                The page you have requested does not exist. Check the address you have typed in the browser or go back home.
                                        <?php elseif ($error['code'] == 403): ?>
                                                You do not have the privilege to access this page.
                                        <?php elseif ($error['code'] == 400): ?>
                                                <?php echo CHtml::encode($error['message']); ?>
                                        <?php else: ?>
                                                We sent a highly trained sloth to fix it, not really but it will get fixed.
                                        <?php endif; ?>
                                        <br/><a href="<?php echo Yii::app()->createUrl('default/index') ?>">Go Back Home >></a>
                                </h3>
                        </div>
                </div><!--/.main-container-->
        </body>
</html>