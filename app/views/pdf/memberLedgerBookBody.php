<?php if (!empty($months)): ?>
    <?php
    $netIncomes = $netExpenditures = $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ?
            Expenditures::model()->netCashOrBankIncomeAfterYesterday($since, $member) :
            Expenditures::model()->netMembersIncomeAfterYesterday($member, $since, $till);

    if (is_array($netIncomes)) {
        $pendingLoans = $netIncomes['expenditure']['pendingTotal'];
        $pendingSavings = $netIncomes['income']['pendingSaving'];
        $netIncomes = $netExpenditures = $netIncomes['income']['total'] - $netIncomes['expenditure']['total'];
    }

    if ($netIncomes < 0) {
        $netExpenditures = abs($netExpenditures);
        $netIncomes = 0;
    } else
        $netExpenditures = 0;

    $member = $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ? $member : Person::model()->findByPk($member);

    $taito = (is_object($member) ? "$member->first_name $member->middle_name $member->last_name's" : $member) . ' Account'
    ?>
    <table style="margin: 0; padding: 0">
        <tr>
            <td colspan="2" style="text-align: center"><?php echo strtoupper($taito); ?></td>
        </tr>

        <tr>
            <td style="text-align: center; border-bottom: 2px solid #000000"><?php echo $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ? 'Debit' : 'Credit'; ?></td>
            <td style="text-align: center; border-bottom: 2px solid #000000"><?php echo $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ? 'Credit' : 'Debit'; ?></td>
        </tr>

        <tr>
            <td style="border-right: 2px solid #000000" size="8">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right"><font size="9">Sh.</font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right"><font size="9">Sh.</font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php if ($netExpenditures != $netIncomes): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netIncomes != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $since; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance b/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if (!empty($netIncomes)) echo $netIncomes; ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netExpenditures != 0): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $since; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance b/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if (!empty($netExpenditures)) echo $netExpenditures; ?></font></td>
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
                                    <td style="width: 50px"><font size="8"><?php if ($income->date != $prvsDate) echo $income->date; ?></font></td>
                                    <td style="width: 150px"><font size="8"><?php echo $income->description; ?></font></td>
                                    <td style="width: 50px; text-align: right"><font size="8"><?php
                                        echo $income->amount;
                                        $netIncomes = $netIncomes + $income->amount;
                                        ?></font></td>
                                </tr>

                                <?php if ($member != ContributionsByMembers::PAYMENT_BY_CASH && $member != ContributionsByMembers::PAYMENT_BY_BANK): ?>
                                    <?php if ($income->trans_channes == Incomes::INCOME_BY_CONTRIBUTION || $income->trans_channes == Incomes::INCOME_BY_CASH_SAVING): ?>
                                        <?php
                                        $savingValues = Savings::model()->profitEarnedOrToBeEarnedOnSavingBetweenAndIncludingTheseDates(
                                                $income->trans_channes == Incomes::INCOME_BY_CONTRIBUTION ? ContributionsByMembers::model()->savingIdForContribution($income->associated_id) : $income->associated_id, '0000-00-00', $till
                                        );
                                        ?>
                                        <?php if (!empty($savingValues[Savings::INTEREST])): ?>
                                            <tr>
                                                <td style="width: 50px"><font size="8"><?php if ($income->date != $prvsDate) echo $income->date; ?></font></td>
                                                <td style="width: 150px"><font size="8">Interest</font></td>
                                                <td style="width: 50px; text-align: right"><font size="8"><?php
                                                    echo $savingValues[Savings::INTEREST];
                                                    $netIncomes = $netIncomes + $savingValues[Savings::INTEREST];
                                                    ?></font></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php $prvsDate = $income->date; ?>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </td>

                <?php $prvsDate = null; ?>
                <td size="8">
                    <table style="margin: 0; padding: 0">
                        <?php foreach ($expenditures as $expenditure): ?>
                            <?php if (substr($expenditure->date, 0, 7) == $month): ?>
                                <tr>
                                    <td style="width: 50px"><font size="8"><?php if ($expenditure->date != $prvsDate) echo $expenditure->date; ?></font></td>
                                    <td style="width: 150px"><font size="8"><?php echo $expenditure->description; ?></font></td>
                                    <td style="width: 50px; text-align: right"><font size="8"><?php
                                        echo $expenditure->amount;
                                        $netExpenditures = $netExpenditures + $expenditure->amount;
                                        ?></font></td>
                                </tr>

                                <?php if ($member != ContributionsByMembers::PAYMENT_BY_CASH && $member != ContributionsByMembers::PAYMENT_BY_BANK): ?>
                                    <?php if ($expenditure->trans_channes == Expenditures::LOANING_CHANNEL): ?>
                                        <?php $loanValues = LoanRepayments::model()->profitEarnedOrToBeEarnedOnLoanBetweenAndIncludingTheseDates($expenditure->associated_id, $till); ?>
                                        <?php if (!empty($loanValues[LoanRepayments::INTEREST])): ?>
                                            <tr>
                                                <td style="width: 50px"><font size="8"><?php if ($expenditure->date != $prvsDate) echo $expenditure->date; ?></font></td>
                                                <td style="width: 150px"><font size="8">Interest</font></td>
                                                <td style="width: 50px; text-align: right"><font size="8"><?php
                                                    echo $loanValues[LoanRepayments::INTEREST];
                                                    $netExpenditures = $netExpenditures + $loanValues[LoanRepayments::INTEREST];
                                                    ?></font></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php $prvsDate = $expenditure->date; ?>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (!empty($pendingLoans) || !empty($pendingSavings)): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if (!empty($pendingSavings)): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="8">Savings Balances</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php echo round($pendingSavings, 2); ?></font></td>
                            </tr>
                        </table>
                        <?php $netIncomes = $netIncomes + $pendingSavings; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($pendingLoans)): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="8">Loan Balances</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php echo round($pendingLoans, 2); ?></font></td>
                            </tr>
                        </table>
                        <?php $netExpenditures = $netExpenditures + $pendingLoans; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($netExpenditures != $netIncomes): ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netExpenditures > $netIncomes): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance c/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if ($netExpenditures > $netIncomes) echo round($netExpenditures - $netIncomes, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netIncomes > $netExpenditures): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $till; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance c/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if ($netIncomes > $netExpenditures) echo round($netIncomes - $netExpenditures, 2); ?></font></td>
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
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netExpenditures > $netIncomes ? $netExpenditures : $netIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right; border-top: 1px solid #000000; border-bottom: 1px solid #000000"><font size="8"><?php echo $netExpenditures > $netIncomes ? $netExpenditures : $netIncomes; ?></font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="border-right: 2px solid #000000" size="8">
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right"><font size="8"></font></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="margin: 0; padding: 0">
                    <tr>
                        <td style="width: 50px"><font size="8"></font></td>
                        <td style="width: 150px"><font size="8"></font></td>
                        <td style="width: 50px; text-align: right"><font size="8"></font></td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php if ($netExpenditures != $netIncomes): ?>
            <?php $morrow = LoanApplications::model()->dayAfter($till); ?>
            <tr>
                <td style="border-right: 2px solid #000000" size="8">
                    <?php if ($netIncomes > $netExpenditures): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $morrow; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance b/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if ($netIncomes > $netExpenditures) echo round($netIncomes - $netExpenditures, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($netExpenditures > $netIncomes): ?>
                        <table style="margin: 0; padding: 0">
                            <tr>
                                <td style="width: 50px"><font size="8"><?php echo $morrow; ?></font></td>
                                <td style="width: 150px"><font size="8">Balance b/d</font></td>
                                <td style="width: 50px; text-align: right"><font size="8"><?php if ($netExpenditures > $netIncomes) echo round($netExpenditures - $netIncomes, 2); ?></font></td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
<?php endif; ?>