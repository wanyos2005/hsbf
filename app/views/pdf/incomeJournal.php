
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::JOURNAL_HEADING), 'subHeading' => Pdf::INCOME_JOURNAL_SUBHEADING)); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.incomeJournalBody', array('incomes' => $incomes, 'since' => $since, 'till' => $till)); ?>

