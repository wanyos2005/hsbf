<table style="width: 100%; padding: 0; margin: 0">
    <tr style="text-align: center; position: relative; padding: 0; margin: 0"><td colspan="3"><h4>Receipt Acknowledgements</h4></td></tr>
</table>

<div style="width: 99%; overflow-y: scroll; border-left: 2px solid #000000">
    <table style="width: 99%; padding: 0; margin: 0">
        <tr>
            <td style="width: <?php echo $no = 10; ?>%; font-weight: bold; text-align: center">No.</td>
            <td style="width: <?php echo $type = 30; ?>%; font-weight: bold">Type Of Contribution</td>
            <td style="width: <?php echo $tarehe = 25; ?>%; font-weight: bold; text-align: center">Date</td>
            <td style="width: <?php echo $kiasi = 20; ?>%; font-weight: bold; text-align: center">Amount</td>
            <td style="width: <?php echo $risiti = 15; ?>%; font-weight: bold; text-align: center">Receipt</td>
        </tr>
    </table>
</div>

<div style="width: 99%; height: 265px; overflow-y: scroll; border-left: 2px solid #000000">

    <table style="width: 100%; padding: 0; margin: 0">
        <?php $i = 0; ?>
        <?php foreach ($receipts as $receipt): ?>
            <?php
            $total = 0;

            foreach (
            $contributions = ContributionsByMembers::model()->findAll('receiptno=:rcpt', array(':rcpt' => $receipt->receiptno)) as $contribution)
                $total = $total + $contribution->amount;
            ?>

            <?php $endDate = substr($endDate = $receipt->date, 8, 2) . ' ' . Defaults::monthName(substr($endDate, 5, 2)) . ' ' . substr($endDate, 0, 4); ?>
            <tr>
                <td style="width: <?php echo $no; ?>%; text-align: center"><?php echo ++$i ?>.</td>
                <td style="width: <?php echo $type; ?>%;"><?php echo $receipt->contribution_type == 3 ? 'Savings' : 'Monthly Contribution'; ?></td>
                <td style="width: <?php echo $tarehe; ?>%"><?php echo $endDate ?></td>
                <td style="width: <?php echo $kiasi; ?>%; text-align: center"><?php echo round($total, 0) ?></td>
                <td style="width: <?php echo $risiti; ?>%; text-align: center">
                    <a href="<?php echo $this->createUrl('printReceipts', array('bala' => $receipt->receiptno)) ?>" target="_blank"><?php echo Lang::t($receipt->receiptno) ?></a>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>