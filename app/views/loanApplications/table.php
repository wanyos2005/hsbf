<?php
if (empty($form)) {
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'loan-applications-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );

    $end = true;
}
?>

<table>
    <?php
    $this->renderPartial('requisites', array('model' => $model, 'others' => $others, 'form' => $form));

    if (!empty($model->loan_type)) {
        $this->renderPartial('witness', array('model' => $model, 'others' => $others, 'form' => $form));
        if ($model->loan_type == 4)
            $this->renderPartial('guarantors', array('model' => $model, 'others' => $others, 'form' => $form));
        else
            $this->renderPartial('guarantor1', array('model' => $model, 'others' => $others, 'form' => $form, 'hidden' => true));

        $this->renderPartial('approvals', array('model' => $model, 'others' => $others, 'form' => $form));
    } else {
        $this->renderPartial('witness', array('model' => $model, 'others' => $others, 'form' => $form, 'hidden' => true));
        $this->renderPartial('guarantor1', array('model' => $model, 'others' => $others, 'form' => $form, 'hidden' => true));
    }

    $this->renderPartial('payslip', array('model' => $model, 'form' => $form));
    ?>
</table>

<?php
if (!empty($end))
    $this->endWidget();