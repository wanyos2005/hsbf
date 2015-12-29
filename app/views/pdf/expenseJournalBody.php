<table>
    <tr>
        <td style="display:table-cell; text-align:left; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">Currency: KSHS</font>
        </td>

        <?php $endDate = substr($since, 8, 2) . ' ' . Defaults::monthName(substr($since, 5, 2)) . ' ' . substr($since, 0, 4); ?>
        <td style="display:table-cell; text-align:center; width:200px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">From : <?php echo $endDate; ?></font>
        </td>
        <?php $endDate = substr($till, 8, 2) . ' ' . Defaults::monthName(substr($till, 5, 2)) . ' ' . substr($till, 0, 4); ?>
        <td style="display:table-cell; text-align:right; width:200px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">To: <?php echo $endDate; ?></font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:90px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="9">DATE</font>
        </td>
        <td style="display:table-cell; text-align:center; width:85px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="9">VOUCHER NO.</font>
        </td>
        <td style="display:table-cell; text-align:center; width:175px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="9">PARTICULARS</font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="9">FOLIO</font>
        </td>
        <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="9">AMOUNT</font>
        </td>
    </tr>

    <?php $previousDate = null; ?>
    <?php foreach ($expenses as $expense): ?>
        <?php $endDate = substr($expense->date, 8, 2) . ' ' . substr(Defaults::monthName(substr($expense->date, 5, 2)), 0, 3) . ' ' . substr($expense->date, 0, 4); ?>
        <tr>
            <td style="display:table-cell; text-align:center; width:90px; height: 12px; border-left: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="9">
                <?php if ($expense->date != $previousDate) echo $endDate; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:85px; height: 12px; border-left: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="9">
                <?php echo $expense->receipt_no; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:left; width:175px; height: 12px; border-left: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="9">
                <?php echo $expense->description; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-left: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="9">
                <?php echo null ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="9">
                <?php echo $expense->amount; ?>
                </font>
            </td>
        </tr>
        <?php $previousDate = $expense->date; ?>
    <?php endforeach; ?>

    <tr>
        <td style="display:table-cell; text-align:center; width:90px; height: 10px; border-left: 2px solid #000000; border-bottom: 2px solid #000000">&nbsp;</td>
        <td style="display:table-cell; text-align:center; width:85px; height: 10px; border-left: 1px solid #000000; border-bottom: 2px solid #000000">&nbsp;</td>
        <td style="display:table-cell; text-align:center; width:175px; height: 10px; border-left: 1px solid #000000; border-bottom: 2px solid #000000">&nbsp;</td>
        <td style="display:table-cell; text-align:center; width:70px; height: 10px; border-left: 1px solid #000000; border-bottom: 2px solid #000000">&nbsp;</td>
        <td style="display:table-cell; text-align:center; width:80px; height: 10px; border-left: 1px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000">&nbsp;</td>
    </tr>

</table>