<tr <?php if (isset($hidden)): $model->guarantor1 = null; ?>hidden="1" <?php endif; ?>>
    <td><?php echo $form->labelEx($model, 'guarantor1'); ?></td>
    <td>&nbsp;</td>
    <td>
        <?php if ($others['readOnly'] == true): ?>
            <?php
            $person = Person::model()->findByPk($model->guarantor1);
            if (!empty($person))
                echo $form->textField($model, 'guarantor1', array('value' => "$person->last_name $person->first_name $person->middle_name", 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
            ?>
        <?php else: ?>
            <?php
            $bandu = $this->otherGaranta($model->member, $model->witness, $model->guarantor2);

            echo $form->dropDownList($model, 'guarantor1', $bandu, array('prompt' => '-- Select A Member --', 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                    'url' => CController::createUrl('loanApplications/guarantor1'), 'update' => '#LoanApplications_guarantor2')));
            ?>
        <?php endif; ?>
    </td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->guarantor1_date)) echo $form->labelEx($model, 'guarantor1_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->guarantor1_date)) echo $form->textField($model, 'guarantor1_date', array('size' => 13, 'maxlength' => 10, 'readonly' => true, 'style' => 'text-align:center')); ?></td>
    <td>&nbsp;</td>
</tr>