
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::LEDGER_BOOK_HEADING), 'subHeading' => "$since - $till")); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.memberLedgerBookBody', array('incomes' => $incomes, 'expenditures' => $expenditures, 'months' => $months, 'since' => $since, 'till' => $till, 'member' => $member)); ?>

