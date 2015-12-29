
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::LOAN_APPLICATION_HEADING), 'subHeading' => strtoupper(Pdf::LOAN_APPLICATION_SUBHEADING))); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.loanBody', array('loan' => $loan)); ?>

