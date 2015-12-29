
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::JOURNAL_HEADING), 'subHeading' => Pdf::EXPENDITURE_JOURNAL_SUBHEADING)); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.expenseJournalBody', array('expenses' => $expenses, 'since' => $since, 'till' => $till)); ?>

