<tr>
    <td><?php echo $form->labelEx($model, 'loan_type'); ?></td>
    <td>&nbsp;</td>
    <td>
        <?php if ($others['readOnly'] == true): ?>
            <?php
            $loantype = Loans::model()->findByPk($model->loan_type);
            echo $form->textField($model, 'loan_type', array('value' => $loantype->loan_type, 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
            ?>

        <?php else: ?>
            <?php
            $array = Loans::model()->findAll(array('order' => 'loan_type ASC'));
            $array = CHtml::listData($array, 'id', 'loan_type');

            $source = array('loniSi' => empty($model->id) ? 'new' : $model->id, 'member' => $model->member, 'source' => empty($others['source']) ? null : $others['source']);

            echo $form->dropDownList($model, 'loan_type', $array, array('prompt' => '-- Loan Type --', 'required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                    'url' => CController::createUrl('loanApplications/renderPartialForm', $source), 'update' => '#fomu')));

            echo $form->hiddenField($model, 'member');
            ?>
        <?php endif; ?>
    </td>
    <td>&nbsp;</td>
    <td><?php echo $form->error($model, 'loan_type'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr><td>&nbsp;</td></tr>

<?php if (!empty($model->loan_type)): ?>
    <tr>
        <td><?php echo $form->labelEx($model, 'amout_borrowed'); ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->textField($model, 'amout_borrowed', array('size' => 13, 'maxlength' => 11, 'placeholder' => 'KShs', 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly'])); ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->labelEx($model, 'repayment_period'); ?></td>
        <td>&nbsp;</td>
        <td>
            <?php if ($others['readOnly'] == true): ?>
                <?php
                echo $form->textField($model, 'repayment_period', array('value' => "$model->repayment_period Months", 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
                ?>
            <?php else: ?>
                <?php
                $loan = Loans::model()->defaultLoanParameters($model->loan_type);
                for ($i = 1; $i <= $loan->repayment_period; $i++) {
                    $months[$i]['id'] = $i;
                    $months[$i]['val'] = "$i Months";
                }
                $months = CHtml::listData($months, 'id', 'val');

                echo $form->dropDownList($model, 'repayment_period', $months, array('prompt' => '-- Months --', 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
                ?>
            <?php endif; ?>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $form->error($model, 'amout_borrowed'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $form->error($model, 'repayment_period'); ?></td>
    </tr>
    
    <tr><td>&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'basic_pay'); ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->textField($model, 'basic_pay', array('size' => 13, 'maxlength' => 11, 'placeholder' => 'KShs', 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly'])); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6"><?php echo $form->error($model, 'basic_pay'); ?></td>
    </tr>
    
    
    <tr><td>&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'present_net_pay'); ?></td>
        <td>&nbsp;</td>
        <td><?php echo $form->textField($model, 'present_net_pay', array('size' => 13, 'maxlength' => 11, 'placeholder' => 'KShs', 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly'])); ?></td>
        <td>&nbsp;</td>
        <td><?php if (!empty($model->net_pay_after_loan_repayment)) echo $form->labelEx($model, 'net_pay_after_loan_repayment'); ?></td>
        <td>&nbsp;</td>
        <td><?php if (!empty($model->net_pay_after_loan_repayment)) echo $form->textField($model, 'net_pay_after_loan_repayment', array('size' => 13, 'maxlength' => 11, 'placeholder' => 'KShs', 'required' => false, 'style' => 'text-align:center', 'readonly' => true)); ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $form->error($model, 'present_net_pay'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><?php if (!empty($model->net_pay_after_loan_repayment)) echo $form->error($model, 'net_pay_after_loan_repayment'); ?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
<?php endif; ?>