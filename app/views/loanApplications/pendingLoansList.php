<div style="overflow-x: hidden">
    <table style="width: 100%">
        <tr style="text-align: center; position: relative"><td colspan="3"><h5><b>Possible Applications</b></h5></td></tr>
    </table>

    <table style="width: 100%; border-left: 2px solid #000000">

        <?php
        $i = 0;
        foreach ($loans as $model)
            if ($model->id !== $selectedId):
                ?>
                <?php
                if (!empty($model->loan_type))
                    $loanType = Loans::model()->findByPk($model->loan_type);
                else {
                    $loanType = new Loans;
                    $loanType->loan_type = 'New Loan Application';
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: center"><?php echo ++$i; ?>.</td>
                    <td>&nbsp;</td>
                    <td><?php echo CHtml::link($loanType->loan_type, array('/loanApplications/myPendingLoanApplications', 'id' => $model->member, 'loniSi' => empty($model->id) ? 'new' : $model->id)); ?></td>
                </tr>
        <?php  endif; ?>

    </table>
</div>
