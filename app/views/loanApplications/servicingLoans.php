<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contributions-by-members-form',
    'enableAjaxValidation' => true,
        ));
?>
<table style="width: 100%">
    <tr>
        <td style="text-align: center; border-top: 1px solid black"><b>Pending Loans</b></td>
    </tr>

    <tr>
        <td>
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="text-align: center">Loan</td>
                        <td style="text-align: center">Date</td>
                        <td style="text-align: center">Balance</td>
                        <td style="text-align: center">Repayment</td>
                    </tr>
                    <?php foreach ($loansMemberIsServicing as $loanApplicationId => $loanMemberIsServicing): ?>
                        <?php
                        if (get_class($loanMemberIsServicing) == 'LoanRepayments') {
                            $model = $loanMemberIsServicing;
                            $loanMemberIsServicing = LoanApplications::model()->findByPk($loanApplicationId);
                        }
                        ?>
                        <?php $loan = Loans::model()->findByPk($loanMemberIsServicing->loan_type); ?>
                        <?php $amountDue = LoanApplications::model()->computeTotals(array($loanMemberIsServicing), $date); ?>
                        <tr>
                            <td><?php echo $loan->loan_type; ?></td>
                            <td style="text-align: center"><?php echo $loanMemberIsServicing->close_date; ?></td>
                            <td style="text-align: center"><?php echo $form->textField($model, "[$loanMemberIsServicing->primaryKey]balance", array('size' => 8, 'value' => $amountDue, 'readonly' => true, 'style' => 'text-align: center')); ?></td>
                            <td style="text-align: center"><?php echo $form->textField($model, "[$loanMemberIsServicing->primaryKey]amountrecovered", array('size' => 8, 'maxLength' => 8, 'placeholder' => 'KShs', 'style' => 'text-align: center')); ?></td>
                            <td><?php echo $form->error($model, 'amountrecovered', array('style' => 'font-size: 80%')); ?></td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
</table>

<?php $this->endWidget(); ?>