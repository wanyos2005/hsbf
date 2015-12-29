<?php $this->renderPartial('guarantor1', array('model' => $model, 'others' => $others, 'form' => $form)); ?>

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $form->error($model, 'guarantor1'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php if (!empty($model->guarantor1_date)) echo $form->error($model, 'guarantor1_date'); ?></td>
</tr>
<tr><td>&nbsp;</td></tr>

<tr>
    <td><?php echo $form->labelEx($model, 'guarantor2'); ?></td>
    <td>&nbsp;</td>
    <td>
        <?php if ($others['readOnly'] == true): ?>
            <?php
            $person = Person::model()->findByPk($model->guarantor2);
            if (!empty($person))
                echo $form->textField($model, 'guarantor2', array('value' => "$person->last_name $person->first_name $person->middle_name", 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
            ?>
        <?php else: ?>
            <?php
            $bandu = $this->otherGaranta($model->member, $model->witness, $model->guarantor1);

            echo $form->dropDownList($model, 'guarantor2', $bandu);
            ?>
        <?php endif; ?>
    </td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->guarantor2_date)) echo $form->labelEx($model, 'guarantor2_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->guarantor2_date)) echo $form->textField($model, 'guarantor2_date', array('size' => 13, 'maxlength' => 10, 'readonly' => true, 'style' => 'text-align:center')); ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $form->error($model, 'guarantor2'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php if (!empty($model->guarantor2_date)) echo $form->error($model, 'guarantor2_date'); ?></td>
</tr>
<tr><td>&nbsp;</td></tr>