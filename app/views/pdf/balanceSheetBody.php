<?php if (!empty($months)): ?>
    <?php
    $netIncomes = $netExpenditures = Expenditures::model()->netIncomeAfterYesterday($since);
    if ($netIncomes < 0) {
        $netExpenditures = abs($netExpenditures);
        $netIncomes = 0;
    } else
        $netExpenditures = 0;
    ?>
    <table style="margin: 0; padding: 0">
        <tr>
            <td style="text-align: center; border-bottom: 2px solid #000000">Assets</td>
            <td style="text-align: center; border-bottom: 2px solid #000000">Liabilities</td>
        </tr>

        <?php if ($netExpenditures + $netIncomes != 0): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="9">
                    <?php if ($netIncomes != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 200px"><font size="9">Cash</font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo $netIncomes; ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netExpenditures != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 200px"><font size="9">Cash</font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo $netExpenditures; ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td style="border-right: 2px solid #000000" size="9">
                <table style="margin: 0; padding: 0">
                    <?php
                    foreach ($dates as $date => $null)
                        foreach (Expenditures::model()->dailyBatchTransactions($incomes, $date) as $description => $income):
                            ?>
                            <tr>
                                <td style="width: 200px"><font size="9"><?php echo $description; ?></font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo $income; ?></font></td>
                            </tr>
                            <?php $netIncomes = $netIncomes + $income; ?>
                        <?php endforeach; ?>
                </table>
            </td>

            <td size="9">
                <table style="margin: 0; padding: 0">
                    <?php
                    foreach ($dates as $date => $null)
                        foreach (Expenditures::model()->dailyBatchTransactions($expenditures, $date) as $description => $expenditure):
                            ?>
                            <tr>
                                <td style="width: 200px"><font size="9"><?php echo $description; ?></font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo $expenditure; ?></font></td>
                            </tr>
                            <?php $netExpenditures = $netExpenditures + $expenditure; ?>
                        <?php endforeach; ?>
                </table>
            </td>
        </tr>

        <?php if ($netExpenditures != $netIncomes): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="9">
                    <?php if ($netExpenditures > $netIncomes): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="9"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="9">Balance c/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo round($netExpenditures - $netIncomes, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netIncomes > $netExpenditures): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="9"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="9">Balance c/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="9"><?php echo round($netIncomes - $netExpenditures, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td style="border-right: 2px solid #000000" size="9">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 200px"><font size="9"></font></td>
                        <td style="width: 50px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="9"><?php echo $netExpenditures > $netIncomes ? $netExpenditures : $netIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 200px"><font size="9"></font></td>
                        <td style="width: 50px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="9"><?php echo $netExpenditures > $netIncomes ? $netExpenditures : $netIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php endif; ?>