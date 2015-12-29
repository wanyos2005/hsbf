
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::TRIAL_BALANCE_HEADING), 'subHeading' => "As At $till")); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.trialBalanceBody', array('rows' => $rows, 'till' => $till)); ?>

