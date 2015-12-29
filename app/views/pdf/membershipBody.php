
<table>
    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            I hereby apply for membership and agree to conform to the Fund Constitution or any amendments thereof:-
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12">PERSONAL DETAILS</font>
        </td>
        <!--
        <td style="display:table-cell; text-align:right; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12"><?php echo "MEMBERSHIP NO.: $person->membershipno"; ?></font>
        </td>
        -->
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Name:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo strtoupper("$person->first_name $person->middle_name $person->last_name"); ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">ID / No.:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php echo $person->idno; ?>
            </font>
        </td>
    </tr>

    <?php
    $dob = empty($person->birthdate) ? null :
            substr($person->birthdate, 8, 2) . ' ' . Defaults::monthName(substr($person->birthdate, 5, 2)) . ' ' . substr($person->birthdate, 0, 4);
    $age = empty($person->birthdate) || empty($person->date_created) ? null :
            substr($person->date_created, 0, 4) - substr($person->birthdate, 0, 4);
    ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Date Of Birth:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($dob)) echo $dob; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Age:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($age)) echo "$age Yrs"; ?>
            </font>
        </td>
    </tr>

    <?php
    $department = empty($person->department) ? null :
            Departments::model()->findByPk($person->department);
    ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Department:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($department)) echo $department->department; ?>
            </font>
        </td>
        <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Payroll No.:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($person->payrollno)) echo $person->payrollno; ?>
            </font>
        </td>
    </tr>

    <?php $address = PersonAddress::model()->addressForPerson($person->primaryKey); ?>
    <tr>
        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Present Address:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:350px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($address)) echo strtoupper($address->address); ?>
            </font>
        </td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:150px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="11">Permanent Address:</font>
        </td>
        <td style="display:table-cell; text-align:justify; width:350px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            <?php if (!empty($address)) echo strtoupper($address->address2); ?>
            </font>
        </td>
    </tr>

    <?php $kins = KinsAndNominees::model()->kinsOrNominees(KinsAndNominees::model()->nextOfKinsOfAMember($person->primaryKey)); ?>
    <?php if (!empty($kins)): ?>

        <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

        <tr>
            <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">NEXT OF KINS' DETAILS</font>
            </td>
        </tr>

        <tr>
            <td style="display:table-cell; text-align:center; width:150px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">NAME</font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">ID. Number</font>
            </td>
            <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Mobile Number</font>
            </td>
            <td style="display:table-cell; text-align:center; width:170px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Postal Address</font>
            </td>
        </tr>

        <?php foreach ($kins as $kin): ?>

            <?php $dependent = DependentMembers::model()->findByPk($kin->dependent_member); ?>
            <tr>
                <td style="display:table-cell; text-align:left; width:150px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->idno; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->mobileno; ?></font>
                </td>
                <td style="display:table-cell; text-align:left; width:170px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->postaladdress; ?></font>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12">SPOUSE'S DETAILS</font>
        </td>
    </tr>

    <?php $spouses = DependentMembers::model()->returnDependentsOfMember($person->primaryKey, 4, 9); ?>

    <?php if (empty($spouses)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">Name:</font>
            </td>
            <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
                <font style="font-family: sans-serif; font-weight: normal" size="11">N / A</font>
            </td>
            <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">ID / No.:</font>
            </td>
            <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
                <font style="font-family: sans-serif; font-weight: normal" size="11">N / A</font>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($spouses as $spouse): ?>
            <tr>
                <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11">Name:</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:250px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $spouse->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:justify; width:80px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11">ID / No.:</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:70px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $spouse->idno; ?></font>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php $children = DependentMembers::model()->returnDependentsOfMember($person->primaryKey, 5, 10); ?>
    <?php if (!empty($children)): ?>
        <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

        <tr>
            <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">CHILDREN'S DETAILS</font>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="display:table-cell; text-align:center; width:350px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">Name</font>
            </td>
            <td style="display:table-cell; text-align:center; width:150px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">Date Of Birth</font>
            </td>
        </tr>

        <?php $i = 0; ?>
        <?php foreach ($children as $child): ?>
            <?php
            $dob = empty($child->dob) ? null :
                    substr($child->dob, 8, 2) . ' ' . Defaults::monthName(substr($child->dob, 5, 2)) . ' ' . substr($child->dob, 0, 4);
            ?>

            <tr>
                <td style="display:table-cell; text-align:right; width:30px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11"><?php echo ++$i; ?>.</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:320px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $child->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:150px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php if (!empty($dob)) echo $dob; ?></font>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    <?php $nominees = KinsAndNominees::model()->kinsOrNominees(KinsAndNominees::model()->nomineesOfAMember($person->primaryKey)); ?>
    <?php if (!empty($nominees)): ?>

        <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

        <tr>
            <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">NOMINEES' DETAILS</font>
            </td>
        </tr>

        <tr>
            <td style="display:table-cell; text-align:center; width:180px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">NAME</font>
            </td>
            <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Relationship</font>
            </td>
            <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">ID. Number</font>
            </td>
            <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">Mobile Number</font>
            </td>
            <td style="display:table-cell; text-align:center; width:40px; height: 12px; border: 1px solid #000000">
                <font style="font-family: sans-serif; font-weight: bold; line-height: 1" size="11">%</font>
            </td>
        </tr>

        <?php foreach ($nominees as $nominee): ?>

            <?php $dependent = DependentMembers::model()->findByPk($nominee->dependent_member); ?>

            <tr>
                <td style="display:table-cell; text-align:left; width:180px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo Relationships::model()->returnRelationship($dependent->relationship); ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:80px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->idno; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:100px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $dependent->mobileno; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:40px; height: 12px; border: 1px solid #000000">
                    <font style="font-family: sans-serif; font-weight: normal; line-height: 1" size="11"><?php echo $nominee->percent; ?></font>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    <tr style="page-break-after: always">
        <td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td>
    </tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12">PARENTS' DETAILS</font>
        </td>
    </tr>

    <?php $parents = DependentMembers::model()->returnDependentsOfMember($person->primaryKey, 1, 6); ?>

    <?php if (empty($parents)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">N / A</font>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($parents as $parent): ?>
            <tr>
                <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11"><?php echo $parent->relationship <= 5 ? 'Father' : 'Mother'; ?>'s Name:</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:200px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $parent->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:60px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11">I/D. No.: </font>
                </td>
                <td style="display:table-cell; text-align:center; width:60px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo empty($parent->idno) ? '--' : $parent->idno; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:50px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11">Alive.: </font>
                </td>
                <td style="display:table-cell; text-align:center; width:30px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $parent->alive == 1 ? 'Yes' : 'No'; ?></font>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12">PARENTS-IN-LAWS' DETAILS</font>
        </td>
    </tr>

    <?php $parentsInLaw = DependentMembers::model()->returnDependentsOfMember($person->primaryKey, 2, 7); ?>

    <?php if (empty($parentsInLaw)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">N / A</font>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($parentsInLaw as $parentInLaw): ?>
            <tr>
                <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11"><?php echo $parentInLaw->relationship <= 5 ? 'Father' : 'Mother'; ?>'s Name:</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:200px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $parentInLaw->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:60px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11">I/D. No.: </font>
                </td>
                <td style="display:table-cell; text-align:center; width:60px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo empty($parentInLaw->idno) ? '--' : $parentInLaw->idno; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:50px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11">Alive.: </font>
                </td>
                <td style="display:table-cell; text-align:center; width:30px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $parentInLaw->alive == 1 ? 'Yes' : 'No'; ?></font>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: bold" size="12">SIBLINGS' DETAILS</font>
        </td>
    </tr>

    <?php $siblings = DependentMembers::model()->returnDependentsOfMember($person->primaryKey, 3, 8); ?>

    <?php if (empty($siblings)): ?>
        <tr>
            <td style="display:table-cell; text-align:justify; width:100px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="12">N / A</font>
            </td>
        </tr>
    <?php else: ?>

        <tr>
            <td colspan="2" style="display:table-cell; text-align:center; width:350px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">Name</font>
            </td>
            <td style="display:table-cell; text-align:center; width:150px; height: 12px">
                <font style="font-family: sans-serif; font-weight: bold" size="11">Relationship</font>
            </td>
        </tr>

        <?php $i = 0; ?>
        <?php foreach ($siblings as $sibling): ?>
            <tr>
                <td style="display:table-cell; text-align:right; width:30px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: bold" size="11"><?php echo ++$i; ?>.</font>
                </td>
                <td style="display:table-cell; text-align:justify; width:320px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo $sibling->name; ?></font>
                </td>
                <td style="display:table-cell; text-align:center; width:150px; height: 12px">
                    <font style="font-family: sans-serif; font-weight: normal" size="11"><?php echo Relationships::model()->returnRelationship($sibling->relationship); ?></font>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

    <tr>
        <td style="display:table-cell; text-align:justify; width:500px; height: 12px">
            <font style="font-family: sans-serif; font-weight: normal" size="11">
            I declare that the information given herein is true to the best of my knowledge.
            </font>
        </td>
    </tr>

    <tr><td style="display:table-cell; text-align:center; width:500px; height: 10px">&nbsp;</td></tr>

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


</table>