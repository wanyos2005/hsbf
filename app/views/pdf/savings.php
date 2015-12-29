
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::SAVINGS_HEADING), 'subHeading' => Pdf::SAVINGS_SUBHEADING)); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.savingsBody', array('person' => $person, 'transactions' => $transactions, 'endDate' => $endDate, 'meaning' => 'Net Savings')); ?>

