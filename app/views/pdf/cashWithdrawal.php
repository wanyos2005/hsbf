
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::CASH_WITHDRAWAL_HEADING), 'subHeading' => strtoupper(Pdf::CASH_WITHDRAWAL_SUBHEADING))); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.withdrawalBody', array('withdrawal' => $withdrawal)); ?>

