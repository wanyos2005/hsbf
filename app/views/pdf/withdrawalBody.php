<?php
$person = Person::model()->findByPk($withdrawal->member);
$address = PersonAddress::model()->addressForPerson($person->primaryKey);
?>

<table>
    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">FROM:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:240px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Name: <?php echo strtoupper("$person->first_name $person->middle_name $person->last_name"); ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:30px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">TO: </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:185px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">THE CHAIRMAN</font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:justify; width:240px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Address: <?php echo empty($address) ? null : strtoupper($address->address); ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:30px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:left; width:185px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo strtoupper(Yii::app()->params['adminName']); ?></font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:justify; width:455px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Phone No.: <?php echo empty($address->phone1) ? null : strtoupper($address->phone1); ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:justify; width:455px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            I/D No.: <?php echo $person->idno; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:justify; width:455px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Payroll No.: <?php echo empty($person->payrollno) ? null : $person->payrollno; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:45px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:justify; width:300px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Date: ..................................................
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            DEBIT ACCOUNT: HSBF SAVINGS ACCOUNT
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Dear Sir/Madam,
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            I hereby request to withdraw in <?php echo strtoupper($withdrawal->cash_or_cheque); ?> the sum of KShs. <?php echo $withdrawal->amount ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Amount in words: <?php echo strtoupper(Defaults::moneyValue($withdrawal->amount)); ?> ONLY
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            and debit the same to my HSBF savings account.
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Signed: ...............................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>
    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php
            for ($i = 1; $i <= 40; $i++)
                echo '&nbsp;';
            ?>
            <i>Account holder</i>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px; border-top: 2px solid #000000">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">FOR OFFICIAL USE ONLY</font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Received by: .....................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>
    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php
            for ($i = 1; $i <= 40; $i++)
                echo '&nbsp;';
            ?>
            <i>Secretary</i>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Approved by: .....................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>
    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php
            for ($i = 1; $i <= 40; $i++)
                echo '&nbsp;';
            ?>
            <i>Chairperson</i>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            Effected by: .....................................................................
            &nbsp;
            Date: .................................................
            </font>
        </td>
    </tr>
    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php
            for ($i = 1; $i <= 40; $i++)
                echo '&nbsp;';
            ?>
            <i>Treasurer</i>
            </font>
        </td>
    </tr>

</table>