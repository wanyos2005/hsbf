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
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Receipt No.</font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Principal</font>
        </td>
        <td style="display:table-cell; text-align:center; width:40px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Rate</font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Interest</font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Amount</font>
        </td>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Withdrawal</font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8">Balance</font>
        </td>
    </tr>

    <?php foreach ($transactions as $transaction): ?>

        <?php $endDate = empty($transaction[ContributionsByMembers::DATE]) ? null : substr($endDate = $transaction[ContributionsByMembers::DATE], 8, 2) . ' ' . substr(Defaults::monthName(substr($endDate, 5, 2)), 0, 3) . ' ' . substr($endDate, 0, 4); ?>
        <tr>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $endDate; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[ContributionsByMembers::RECEIPT]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::PRINCIPAL]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:40px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Savings::INTEREST_RATE]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php if (!empty($transaction[Loanrepayments::INTEREST])) echo $transaction[Loanrepayments::INTEREST]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-right: 1px solid #000000;
                <?php if (isset($transaction[Savings::STYLE])): ?>border-top: 1px solid #000000; border-bottom: 1px solid #000000<?php endif; ?>">
                <font style="font-family: sans-serif; font-weight: normal;
                      <?php if (isset($transaction[Savings::STYLE])): ?>text-decoration: underline<?php endif; ?>"
                      size="8">
                      <?php echo $amount =$transaction[Loanrepayments::AMOUNT_DUE]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php if (!empty($transaction[ContributionsByMembers::WITHDRAWAL])) echo $transaction[ContributionsByMembers::WITHDRAWAL]; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal" size="8">
                <?php echo $transaction[Loanrepayments::REDUCING_BALANCE]; ?>
                </font>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td style="display:table-cell; text-align:center; width:65px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:40px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:60px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal" size="8"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
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
            echo "Amount Accumulated is KShs. $amount";
            ?>
            </font>
        </td>
    </tr>

</table>