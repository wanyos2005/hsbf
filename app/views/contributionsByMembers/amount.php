<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contributions-by-members-form',
    'enableAjaxValidation' => true,
        ));
?>
<table style="width: 100%">
   <tr>
        <td>
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 30%"><?php echo $form->labelEx($model, 'amount'); ?></td>
                        <td style="width: 20%; text-align: center"><?php echo $form->textField($model, 'amount', array('size' => 8, 'maxLength' => 8, 'placeholder' => 'KShs', 'required' => true, 'style' => 'text-align:center')); ?></td>
                        <td style="width: 50%"><?php echo $form->error($model, 'amount'); ?></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>

<?php $this->endWidget(); ?>