<table style="width: 100%; padding: 0; margin: 0">
    <tr style="text-align: center; position: relative; padding: 0; margin: 0"><td colspan="3"><h4>Select A Loan</h4></td></tr>
</table>

<div style="width: 99%; height: 270px; overflow-x: hidden; border-left: 2px solid #000000">
    <table style="width: 100%">

        <tr style="text-align: center; position: relative">
            <td><h6><b>No.</b></h6></td><td><h6><b>Loan Type</b></h6></td><td><h6><b>Amount, KShs.</b></h6></td><td><h6><b>Date</b></h6></td>
        </tr>

        <?php foreach ($loans as $i => $model): ?>
            <?php $loanType = Loans::model()->findByPk($model->loan_type); ?>
            <tr>
                <td style="text-align: center"><?php echo $i + 1; ?>.</td>
                <td><?php echo CHtml::link($loanType->loan_type, array('/contributionsByMembers/whichStatement', 'id' => $model->primaryKey, 'type' => 4), array('target' => '_blank')); ?></td>
                <td style="text-align: center"><?php echo $model->amout_borrowed; ?></td>
                <td style="text-align: center"><?php echo $model->close_date; ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>
