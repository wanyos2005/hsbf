
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::BALANCE_SHEET_HEADING), 'subHeading' => "As At $till")); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.balanceSheetBody', array('incomes' => $incomes, 'expenditures' => $expenditures, 'months' => $months, 'dates' => $dates, 'since' => $since, 'till' => $till)); ?>

