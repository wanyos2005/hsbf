<?php if (!empty($rows)): ?>
    <?php $debit = 0; ?>
    <?php $credit = 0; ?>

    <table style="margin: 0; padding: 0">
        <tr>
            <td style="width: 200px; text-align: center; border-top: 1px solid #000000"></td>
            <td style="width: 150px; text-align: right; border-top: 1px solid #000000">Debit</td>
            <td style="width: 150px; text-align: right; border-top: 1px solid #000000">Credit</td>
        </tr>

        <?php foreach ($rows as $row): ?>
            <tr>
                <td style="width: 200px"><font size="9"><?php echo $row['name'] ?></font></td>
                <td style="width: 150px; text-align: right"><font size="9"><?php echo $row['debit'] ?></font></td>
                <td style="width: 150px; text-align: right"><font size="9"><?php echo $row['credit'] ?></font></td>
            </tr>
            <?php $debit = $debit + $row['debit']; ?>
            <?php $credit = $credit + $row['credit']; ?>
        <?php endforeach; ?>

        <tr>
            <td style="width: 200px"><font size="9"></font></td>
            <td style="width: 150px; text-align: right; text-decoration: underline overline; line-height: 1.5"><font size="9"><?php echo $debit ?></font></td>
            <td style="width: 150px; text-align: right; text-decoration: underline overline; line-height: 1.5"><font size="9"><?php echo $credit ?></font></td>
        </tr>
    </table>
<?php endif; ?>