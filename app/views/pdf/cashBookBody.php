<?php if (!empty($months)): ?>
    <?php
    $netBankIncomes = $netBankExpenditures = Expenditures::model()->netCashOrBankIncomeAfterYesterday($since, ContributionsByMembers::PAYMENT_BY_BANK);
    if ($netBankIncomes < 0) {
        $netBankExpenditures = abs($netBankExpenditures);
        $netBankIncomes = 0;
    } else
        $netBankExpenditures = 0;

    $netCashIncomes = $netCashExpenditures = Expenditures::model()->netCashOrBankIncomeAfterYesterday($since, ContributionsByMembers::PAYMENT_BY_CASH);
    if ($netCashIncomes < 0) {
        $netCashExpenditures = abs($netCashExpenditures);
        $netCashIncomes = 0;
    } else
        $netCashExpenditures = 0;
    ?>
    <table style="margin: 0; padding: 0">
        <tr>
            <td style="text-align: center; border-bottom: 2px solid #000000">Debit</td>
            <td style="text-align: center; border-bottom: 2px solid #000000">Credit</td>
        </tr>

        <tr>
            <td style="border-right: 2px solid #000000" size="8">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: center"><font size="8">Bank</font></td>
                        <td style="width: 40px; text-align: center"><font size="8">Cash</font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right"><font size="8">Bank</font></td>
                        <td style="width: 40px; text-align: right"><font size="8">Cash</font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php if ($netBankExpenditures != $netBankIncomes || $netCashExpenditures != $netCashIncomes): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netBankIncomes != 0 || $netCashIncomes != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $since; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance b/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if (!empty($netBankIncomes)) echo $netBankIncomes; ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if (!empty($netCashIncomes)) echo $netCashIncomes; ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netBankExpenditures != 0 || $netCashExpenditures != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $since; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance b/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if (!empty($netBankExpenditures)) echo $netBankExpenditures; ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if (!empty($netCashExpenditures)) echo $netCashExpenditures; ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach ($months as $month => $null): ?>
            <tr>
                <?php $prvsDate = null; ?>
                <td style="border-right: 2px solid #000000" size="8">
                    <table style="margin: 0; padding: 0">
                        <?php foreach ($incomes as $income): ?>
                            <?php if (substr($income->date, 0, 7) == $month): ?>
                                <tr>
                                    <td style="width: 45px"><font size="8"><?php if ($income->date != $prvsDate) echo $income->date; ?></font></td>
                                    <td style="width: 125px"><font size="8"><?php echo $income->description; ?></font></td>
                                    <td style="width: 40px; text-align: right"><font size="8"><?php
                                        if ($income->cask_or_bank == ContributionsByMembers::PAYMENT_BY_BANK) {
                                            echo $income->amount;
                                            $netBankIncomes = $netBankIncomes + $income->amount;
                                        }
                                        ?></font></td>
                                    <td style="width: 40px; text-align: right"><font size="8"><?php
                                        if ($income->cask_or_bank == ContributionsByMembers::PAYMENT_BY_CASH) {
                                            echo $income->amount;
                                            $netCashIncomes = $netCashIncomes + $income->amount;
                                        }
                                        ?></font></td>
                                </tr>
                            <?php endif; ?>
                            <?php $prvsDate = $income->date; ?>
                        <?php endforeach; ?>
                    </table>
                </td>

                <?php $prvsDate = null; ?>
                <td size="8">
                    <table style="margin: 0; padding: 0">
                        <?php foreach ($expenditures as $expenditure): ?>
                            <?php if (substr($expenditure->date, 0, 7) == $month): ?>
                                <tr>
                                    <td style="width: 45px"><font size="8"><?php if ($expenditure->date != $prvsDate) echo $expenditure->date; ?></font></td>
                                    <td style="width: 125px"><font size="8"><?php echo $expenditure->description; ?></font></td>
                                    <td style="width: 40px; text-align: right"><font size="8"><?php
                                        if ($expenditure->cask_or_bank == ContributionsByMembers::PAYMENT_BY_BANK) {
                                            echo $expenditure->amount;
                                            $netBankExpenditures = $netBankExpenditures + $expenditure->amount;
                                        }
                                        ?></font></td>
                                    <td style="width: 40px; text-align: right"><font size="8"><?php
                                        if ($expenditure->cask_or_bank == ContributionsByMembers::PAYMENT_BY_CASH) {
                                            echo $expenditure->amount;
                                            $netCashExpenditures = $netCashExpenditures + $expenditure->amount;
                                        }
                                        ?></font></td>
                                </tr>
                            <?php endif; ?>
                            <?php $prvsDate = $expenditure->date; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if ($netBankExpenditures != $netBankIncomes || $netCashExpenditures != $netCashIncomes): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netBankExpenditures > $netBankIncomes || $netCashExpenditures > $netCashIncomes): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance c/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netBankExpenditures > $netBankIncomes) echo round($netBankExpenditures - $netBankIncomes, 2); ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netCashExpenditures > $netCashIncomes) echo round($netCashExpenditures - $netCashIncomes, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netBankIncomes > $netBankExpenditures || $netCashIncomes > $netCashExpenditures): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance c/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netBankIncomes > $netBankExpenditures) echo round($netBankIncomes - $netBankExpenditures, 2); ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netCashIncomes > $netCashExpenditures) echo round($netCashIncomes - $netCashExpenditures, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td style="border-right: 2px solid #000000" size="8">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netBankExpenditures > $netBankIncomes ? $netBankExpenditures : $netBankIncomes; ?></font></td>
                        <td style="width: 40px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netCashExpenditures > $netCashIncomes ? $netCashExpenditures : $netCashIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netBankExpenditures > $netBankIncomes ? $netBankExpenditures : $netBankIncomes; ?></font></td>
                        <td style="width: 40px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netCashExpenditures > $netCashIncomes ? $netCashExpenditures : $netCashIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="border-right: 2px solid #000000" size="8">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right"><font size="8"></font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 45px"><font size="8"></font></td>
                        <td style="width: 125px"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right"><font size="8"></font></td>
                        <td style="width: 40px; text-align: right"><font size="8"></font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php if ($netBankExpenditures != $netBankIncomes || $netCashExpenditures != $netCashIncomes): ?>
            <?php $morrow = LoanApplications::model()->dayAfter($till); ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netBankIncomes > $netBankExpenditures || $netCashIncomes > $netCashExpenditures): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $morrow; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance b/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netBankIncomes > $netBankExpenditures) echo round($netBankIncomes - $netBankExpenditures, 2); ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netCashIncomes > $netCashExpenditures) echo round($netCashIncomes - $netCashExpenditures, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netBankExpenditures > $netBankIncomes || $netCashExpenditures > $netCashIncomes): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 45px"><font size="8"><?php echo $morrow; ?></font></td>
                                <td style="width: 125px"><font size="8">Balance b/d</font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netBankExpenditures > $netBankIncomes) echo round($netBankExpenditures - $netBankIncomes, 2); ?></font></td>
                                <td style="width: 40px; text-align: right"><font size="8"><?php if ($netCashExpenditures > $netCashIncomes) echo round($netCashExpenditures - $netCashIncomes, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

    </table>
<?php endif; ?>