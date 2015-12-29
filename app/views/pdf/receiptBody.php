<?php
$total = 0;

foreach (
$contributions = ContributionsByMembers::model()->findAll('receiptno=:rcpt', array(':rcpt' => $receipt)) as $contribution)
    $total = $total + $contribution->amount;

$person = Person::model()->findByPk($contribution->member);
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
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Nat. ID. No.:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $person->idno; ?>
            </font>
        </td>

        <?php $endDate = substr($endDate = $contribution->date, 8, 2) . ' ' . Defaults::monthName(substr($endDate, 5, 2)) . ' ' . substr($endDate, 0, 4); ?>
        <td style="display:table-cell; text-align:justify; width:50px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Date:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $endDate; ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Receipt No.:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $receipt; ?>
            </font>
        </td>

        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Amount Paid:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo "KShs. $total"; ?>
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="10">
            This is to acknowledge receipt of your contribution on the Fund account as below described:
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:center; width:300px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">DESCRIPTION</font>
        </td>
        <td style="display:table-cell; text-align:center; width:200px; height: 12px; border: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">AMOUNT, KShs.</font>
        </td>
    </tr>

    <?php foreach ($contributions as $contribution): ?>
        <?php $contributionType = ContributionTypes::model()->findByPk($contribution->contribution_type); ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:300px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="10">
                <?php echo $contributionType->contribution_type; ?>
                </font>
            </td>
            <td style="display:table-cell; text-align:center; width:200px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000">
                <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="10">
                <?php echo $contribution->amount; ?>
                </font>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td style="display:table-cell; text-align:center; width:300px; height: 12px; border-left: 2px solid #000000; border-right: 1px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11"></font>
        </td>
        <td style="display:table-cell; text-align:center; width:200px; height: 12px; border-left: 1px solid #000000; border-right: 2px solid #000000; border-bottom: 2px solid #000000">
            <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11"></font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="10">
            This slip is generated electronically hence not signed or stamped.
            </font>
        </td>
    </tr>


</table>