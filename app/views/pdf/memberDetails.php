
<?php Yii::app()->controller->renderPartial('application.views.pdf.header'); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.heading', array('heading' => strtoupper(Pdf::MEMBERSHIP_HEADING), 'subHeading' => strtoupper(Pdf::MEMBERSHIP_SUBHEADING))); ?>
<?php Yii::app()->controller->renderPartial('application.views.pdf.membershipBody', array('person' => $person)); ?>

