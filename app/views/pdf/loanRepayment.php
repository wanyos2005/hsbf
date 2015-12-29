
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::LOAN_REPAYMENT_HEADING), 'subHeading' => Pdf::LOAN_REPAYMENT_SUBHEADING)); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.loanRepaymentBody', array('loanApplication' => $loanApplication, 'person' => $person, 'transactions' => $transactions, 'endDate' => $endDate)); ?>

