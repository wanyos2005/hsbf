
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::RECEIPT_HEADING))); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.receiptBody', array('receipt' => $receipt)); ?>

