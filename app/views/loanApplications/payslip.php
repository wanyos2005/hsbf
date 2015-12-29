<?php
if (empty($form))
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'loan-applications-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );
?>
<tr>
    <td colspan="8"><b><?php echo $form->labelEx($model, 'payslip'); ?></b></td>
</tr>
<tr>
    <td colspan="8">
        <div>
            <?php
            if (!empty($model->payslip) && file_exists($payslip = Yii::app()->basePath . "\payslips\\$model->payslip")) {
                echo CHtml::image(MyYiiUtils::getThumbSrc($payslip, array('resize' => array('width' => 500))), CHtml::encode('Payslip Not Found'), array('style' => 'text-align: center; border: 3px solid #C9E0ED; border-radius: 6px', 'id' => 'avator', 'class' => 'editable img-responsive'));
                echo "<br/>";
            }

            $image = new Images;

            echo $form->fileField($image, 'image', array('readonly' => true,
                'maxlength' => 6, 'style' => 'width:100%; text-align:center; color:#C9E0ED'));
            ?>
        </div>
    </td>
</tr>
<tr><td>&nbsp;</td></tr>

<?php
if (!empty($end))
    $this->endWidget();