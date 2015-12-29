<?php
$person = Person::model()->findByPk($loan->member);
$address = PersonAddress::model()->addressForPerson($person->primaryKey);
$loanType = Loans::model()->findByPk($loan->loan_type);
?>

<table>
    <tr>
        <td style="display:table-cell; text-align:justify; width:200px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Member’s Full Names:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:300px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo strtoupper("$person->first_name $person->middle_name $person->last_name"); ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:200px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">National Identity Card Number:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:300px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $person->idno; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Address:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:230px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo empty($address) ? null : strtoupper($address->address); ?>
            </font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Phone Number:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo empty($address->phone1) ? null : strtoupper($address->phone1); ?>
            </font>
        </td>
    </tr>

    <tr>
        <!--
        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Membership No.:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
        <?php echo empty($person->membershipno) ? null : strtoupper($person->membershipno); ?>
            </font>
        </td>
        -->

        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Payroll No.:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo empty($person->payrollno) ? null : $person->payrollno; ?>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Present Net Pay:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "KShs. $loan->present_net_pay"; ?>
            </font>
        </td>

        <td style="display:table-cell; text-align:right; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">(Attach Payslip)</font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:180px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Amount of loan applied for:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "KShs. $loan->amout_borrowed"; ?>
            </font>
        </td>

        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Repayment Period:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "$loan->repayment_period Months"; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Loan Type:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:400px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $loanType->loan_type; ?>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            I hereby declare that the foregoing particulars are true to the best of my knowledge and
            I agree with the by-laws of the Fund, the loan policy and variations by the
            Fund Committee in respect to the above.
            I hereby give irrevocable authority to my present and future employers to
            recover this loan and interest of 10% p.a from my salary until the loan is fully repaid. 
            I offer my contribution to the Fund as security for the loan.
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Applicant's Signature: ..........................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>


    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:200px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Name</font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Payroll No.</font>
        </td>
        <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Signature</font>
        </td>
        <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Date</font>
        </td>
    </tr>

    <?php $witness = Person::model()->findByPk($loan->witness); ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11">Witness</font>
        </td>
        <td style="display:table-cell; text-align:left; width:200px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
            <?php echo strtoupper(substr("$witness->first_name $witness->middle_name $witness->last_name", 0, 30)); ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
            <?php if (!empty($witness->payrollno)) echo $witness->payrollno; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
            <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
        </td>
    </tr>

    <?php $guarantor1 = Person::model()->findByPk($loan->guarantor1); ?>
    <?php if (!empty($guarantor1)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:70px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11">Guarantor 1</font>
            </td>
            <td style="display:table-cell; text-align:left; width:200px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
                <?php echo strtoupper(substr("$guarantor1->first_name $guarantor1->middle_name $guarantor1->last_name", 0, 30)); ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
                <?php if (!empty($guarantor1->payrollno)) echo $guarantor1->payrollno; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
            </td>
        </tr>
    <?php endif; ?>

    <?php $guarantor2 = Person::model()->findByPk($loan->guarantor2); ?>
    <?php if (!empty($guarantor2)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:70px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11">Guarantor 2</font>
            </td>
            <td style="display:table-cell; text-align:left; width:200px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
                <?php echo strtoupper(substr("$guarantor2->first_name $guarantor2->middle_name $guarantor2->last_name", 0, 30)); ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:70px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9">
                <?php if (!empty($guarantor2->payrollno)) echo $guarantor2->payrollno; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="9"></font>
            </td>
        </tr>
    <?php endif; ?>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:500px; height: 12px; border-top: 2px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold" size="11">FOR OFFICIAL USE ONLY</font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Secretary’s Comment: .....................................................................................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Signature: ..........................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <?php $totalContributions = ContributionsByMembers::model()->netTotalMemberContribution($loan->member, $loan->witness_date); ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:120px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Total Contributions:</font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "KShs. $totalContributions"; ?>
            </font>
        </td>

        <td style="display:table-cell; text-align:right; width:180px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Net pay after loan repayment:</font>
        </td>

        <td style="display:table-cell; text-align:right; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "KShs. $loan->net_pay_after_loan_repayment"; ?>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Treasurer’s Comment: .....................................................................................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Signature: ..........................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Chairman’s Approval: .....................................................................................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Signature: ..........................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

</table>