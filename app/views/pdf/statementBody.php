
<table>
    <tr>
        <td style="display:table-cell; text-align:justify; width:50px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Name:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:450px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo strtoupper("$person->first_name $person->middle_name $person->last_name"); ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">National ID. No.: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $person->idno; ?>
            </font>
        </td>
        <!--
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Membership No.: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:60px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
        <?php echo $person->membershipno; ?>
            </font>
        </td>
        -->
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Payroll No.: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:60px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $person->payrollno; ?>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <?php $endDate = substr($endDate, 8, 2) . ' ' . Defaults::monthName(substr($endDate, 5, 2)) . ' ' . substr($endDate, 0, 4); ?>
    <tr>
        <td style="display:table-cell; text-align:center; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">Currency: KSHS</font>
        </td>
        <td style="display:table-cell; text-align:right; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">Date: <?php echo $endDate; ?></font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:150px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="11">DATE</font>
        </td>
        <td style="display:table-cell; text-align:center; width:150px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="11">RECEIPT NO.</font>
        </td>
        <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="11">CREDIT</font>
        </td>
        <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="11">DEBIT</font>
        </td>
    </tr>

    <?php
    $deposits = 0;
    $withdrawals = 0;
    $netContributions = 0;
    $count = 0;
    $countTransactions = count($transactions);
    ?>
    <?php foreach ($transactions as $transaction): ?>
        <?php
        $deposits = $deposits + $transaction[ContributionsByMembers::DEPOSIT];
        $withdrawals = $withdrawals + $transaction[ContributionsByMembers::WITHDRAWAL];
        $count++;
        ?>

        <?php $date = substr($det = $transaction[ContributionsByMembers::DATE], 8, 2) . ' ' . Defaults::monthName(substr($det, 5, 2)) . ' ' . substr($det, 0, 4); ?>
        <tr>
            <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="11">
                <?php echo $date; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="11">
                <?php echo $transaction[ContributionsByMembers::RECEIPT]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:100px; height: 12px; border-left: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="11">
                <?php echo $transaction[ContributionsByMembers::DEPOSIT]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:100px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="11">
                <?php echo $transaction[ContributionsByMembers::WITHDRAWAL]; ?>
                </font>
            </td>
        </tr>

        <?php if (!isset($transactions[$count]) || ($year = substr($transactions[$count][ContributionsByMembers::DATE], 0, 4)) != $previousYear = substr($transaction[ContributionsByMembers::DATE], 0, 4)): ?>
            <?php $netContributions = $netContributions + $deposits - $withdrawals; ?>

            <tr>
                <td style="display:table-cell; text-align:center; width:150px; height: 10px; border-left: 2px solid #000000">&nbsp;</td>
                <td style="display:table-cell; text-align:center; width:150px; height: 10px; border-left: 1px solid #000000">&nbsp;</td>
                <td style="display:table-cell; text-align:center; width:100px; height: 10px; border-left: 1px solid #000000">&nbsp;</td>
                <td style="display:table-cell; text-align:center; width:100px; height: 10px; border-left: 1px solid #000000; border-right: 2px solid #000000">&nbsp;</td>
            </tr>

            <?php if (isset($year) && $year != $previousYear): ?>
                <?php $date = '31' . ' ' . Defaults::monthName(12) . ' ' . $previousYear; ?>
                <tr>
                    <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 2px solid #000000">
                        <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $date; ?></font>
                    </td>
                    <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 1px solid #000000">
                        <font style="font-family: sans-serif; font-weight: normal" size="11">Balance c/f</font>
                    </td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                        <?php if ($netContributions >= 0): ?>
                            <font style="font-family: sans-serif; font-weight: normal; text-decoration: underline" size="11">
                            <?php echo $netContributions > 0 ? $netContributions : '0.000'; ?>
                            </font>
                        <?php endif; ?>
                    </td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000; border-right: 2px solid #000000">
                        <?php if ($netContributions < 0): ?>
                            <font style="font-family: sans-serif; font-weight: normal; text-decoration: underline" size="11">
                            <?php echo abs($netContributions); ?>
                            </font>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td style="display:table-cell; text-align:center; width:150px; height: 10px; border-left: 2px solid #000000">&nbsp;</td>
                    <td style="display:table-cell; text-align:center; width:150px; height: 10px; border-left: 1px solid #000000">&nbsp;</td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 10px; border-left: 1px solid #000000">&nbsp;</td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 10px; border-left: 1px solid #000000; border-right: 2px solid #000000">&nbsp;</td>
                </tr>

                <?php $date = '01' . ' ' . Defaults::monthName(01) . ' ' . $year; ?>
                <tr>
                    <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 2px solid #000000">
                        <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $date; ?></font>
                    </td>
                    <td style="display:table-cell; text-align:center; width:150px; height: 12px; border-left: 1px solid #000000">
                        <font style="font-family: sans-serif; font-weight: normal" size="11">Balance b/f</font>
                    </td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 12px; border-left: 1px solid #000000">
                        <?php if ($netContributions >= 0): ?>
                            <font style="font-family: sans-serif; font-weight: normal" size="11">
                            <?php echo $netContributions > 0 ? $netContributions : '0.000'; ?>
                            </font>
                        <?php endif; ?>
                    </td>
                    <td style="display:table-cell; text-align:center; width:100px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                        <?php if ($netContributions < 0): ?>
                            <font style="font-family: sans-serif; font-weight: normal" size="11">
                            <?php echo abs($netContributions); ?>
                            </font>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php unset($year) ?>
            <?php endif; ?>
            <?php
            $deposits = 0;
            $withdrawals = 0;
            ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <tr>
        <td style="display:table-cell; text-align:center; width:300px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $meaning ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 2px solid #000000">
            <?php if ($netContributions >= 0): ?>
                <font style="font-family: sans-serif; font-weight: normal; text-decoration: underline" size="11">
                <?php echo $netContributions > 0 ? $netContributions : '0.000'; ?>
                </font>
            <?php endif; ?>
        </td>
        <?php $absNetContributions = abs($netContributions); ?>
        <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 2px solid #000000">
            <?php if ($netContributions < 0): ?>
                <font style="font-family: sans-serif; font-weight: normal; text-decoration: underline" size="11">
                <?php echo abs($absNetContributions); ?>
                </font>
            <?php endif; ?>
        </td>
    </tr>


</table>