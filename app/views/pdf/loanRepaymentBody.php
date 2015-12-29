<?php
$lastDate = $endDate;
$loanType = Loans::model()->findByPk($loanApplication->loan_type);
?>

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

    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Type of Loan: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:175px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo $loanType->loan_type; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Amount Borrowed: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:125px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo "KSHS. $loanApplication->amout_borrowed"; ?>
            </font>
        </td>
    </tr>

    <?php $endDate = substr($endDate = $loanApplication->close_date, 8, 2) . ' ' . Defaults::monthName(substr($endDate, 5, 2)) . ' ' . substr($endDate, 0, 4); ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Date of Borrowing: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:110px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo $endDate; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Repayment Period: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:60px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo "$loanApplication->repayment_period Months"; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:75px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Interest Rate: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:55px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo "$loanApplication->interest_rate% p.a."; ?>
            </font>
        </td>
    </tr>

    <?php $endDate = substr($endDate = $lastDate, 8, 2) . ' ' . Defaults::monthName(substr($endDate, 5, 2)) . ' ' . substr($endDate, 0, 4); ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Currency: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:150px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">KSHS</font>
        </td>
        <td style="display:table-cell; text-align:right; width:100px; height: 9px">
            <font style="font-family: sans-serif; font-weight: bold" size="9">Enquiry Date: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:150px; height: 9px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php echo $endDate; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Date</font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Receipt No.</font>
        </td>
        <!--
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Principal</font>
        </td>
        -->
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Interest</font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Amount Due</font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Amount Paid</font>
        </td>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Recovery</font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Balance</font>
        </td>
    </tr>

    <?php foreach ($transactions as $transaction): ?>

        <?php $endDate = substr($endDate = $transaction[ContributionsByMembers::DATE], 8, 2) . ' ' . substr(Defaults::monthName(substr($endDate, 5, 2)), 0, 3) . ' ' . substr($endDate, 0, 4); ?>
        <tr>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $endDate; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[ContributionsByMembers::RECEIPT]; ?>
                </font>
            </td>
            <!--
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
            <?php echo $transaction[Loanrepayments::PRINCIPAL]; ?>
                </font>
            </td>
            -->
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::INTEREST]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::AMOUNT_DUE]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::AMOUNT_PAID]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::DEDUCTION_FROM_CONTRIBUTIONS]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::REDUCING_BALANCE]; ?>
                </font>
            </td>
        </tr>

    <?php endforeach; ?>

    <?php $amountDue = $transaction[Loanrepayments::REDUCING_BALANCE]; ?>
    <?php if (($principal = $amountDue) != 0 && $transaction[ContributionsByMembers::DATE] != $endDate = date('Y') . '-' . date('m') . '-' . date('d')): ?>
        <?php
        $amountDue = round(
                LoanRepayments::model()->amountDue(
                        $principal, $loanApplication->interest_rate, $transaction[ContributionsByMembers::DATE], $endDate, $transactions[0][ContributionsByMembers::DATE] == $endDate && count($transactions) == 1 ? 1 : 0
                ), 3);
        ?>

        <?php $endDate = substr($endDate, 8, 2) . ' ' . substr(Defaults::monthName(substr($endDate, 5, 2)), 0, 3) . ' ' . substr($endDate, 0, 4); ?>
        <tr>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $endDate; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
            </td>
            <!--
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
            <?php echo $principal; ?>
                </font>
            </td>
            -->
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo round($amountDue - $principal, 3); ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $amountDue; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
            </td>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $amountDue; ?>
                </font>
            </td>
        </tr>

    <?php endif; ?>

    <tr>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <!--
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        -->
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 10px">
            <font style="font-family: sans-serif; font-weight: normal" size="9">
            <?php
            if ($loanApplication->serviced == 'Yes' && $transaction[Loanrepayments::REDUCING_BALANCE] == 0)
                echo 'Congratulations! The loan is fully serviced.';
            else
            if ($loanApplication->serviced == 'No' && $transaction[Loanrepayments::REDUCING_BALANCE] != 0)
                echo "The loan is still being serviced. The balance due is KSHS. $amountDue";
            else
                echo 'Loan status information is conflicting. Please seek assistance from a relevant authority.';
            ?>
            </font>
        </td>
    </tr>

</table>