
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::MONTHLY_CONTRIBUTIONS_HEADING), 'subHeading' => Pdf::MONTHLY_CONTRIBUTIONS_SUBHEADING)); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.statementBody', array('person' => $person, 'transactions' => $transactions, 'endDate' => $endDate, 'meaning' => 'Net Total Monthly Contributions')); ?>

