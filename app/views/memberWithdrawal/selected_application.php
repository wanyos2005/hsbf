<?php
$member = Person::model()->findByPk($model->member);

$address = PersonAddress::model()->find('person_id=:id', array(':id' => $model->member));
$contributions = ContributionsByMembers::model()->netTotalMemberContribution($model->member, date('Y') . '-' . date('m') . '-' . date('d'));
?>
<div style="height: 400px; border-right: 3px solid #4f99c6">

    <?php if ($model->status == 'Pending'): ?>
        <div style="height: 20px; text-align: center">
            <b><?php echo "$member->last_name $member->first_name $member->middle_name"; ?></b>
        </div>

        <div style="height: 360px; overflow-y: scroll">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'loan-applications-form',
                'enableAjaxValidation' => false,
                    )
            );
            ?>


            <table style="width: 100%">
                <tr>
                    <td><b>Nat. ID. No : </b></td>
                    <td><?php echo "$member->idno"; ?></td>
                    <td><b>Telephone : </b></td>
                    <td><?php echo "$address->phone1"; ?></td>
                </tr>

                <tr>
                    <td><b>Membership No : </b></td>
                    <td><?php echo "$member->membershipno"; ?></td>
                    <td><b>Payroll No : </b></td>
                    <td><?php echo "$member->payrollno"; ?></td>
                </tr>

                <tr>
                    <td><b>Address : </b></td>
                    <td colspan="3"><?php echo "$address->address"; ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <?php if ($attribute['readOnly'] == true): ?>
                    <?php if ($authority != 'secretary'): ?>
                        <tr>
                            <td colspan="2"><?php echo $form->labelEx($model, 'forwarded_by_secretary'); ?></td>
                            <td colspan="2"><?php echo $model->forwarded_by_secretary; ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($authority == 'chairman'): ?>
                        <tr>
                            <td colspan="2"><?php echo $form->labelEx($model, 'forwarded_by_treasurer'); ?></td>
                            <td colspan="2"><?php echo $model->forwarded_by_treasurer; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr>
                        <?php ?>
                        <td colspan="2">
                            <?php
                            echo $form->labelEx($model, $attribute['authority']);
                            echo $form->hiddenField($model, 'id');
                            echo CHtml::hiddenField('authority', $authority);
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $form->dropDownList($model, $attribute['authority'], array('Yes' => 'Yes', 'No' => 'No', 'Pending' => 'Pending'), array('required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                                    'url' => CController::createUrl('memberWithdrawal/save'), 'update' => '#render')));
                            ?>
                        </td>

                        <?php if (!empty($model->$attribute['date'])): ?>
                            <td><?php echo 'On ' . $model->$attribute['date']; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
                    <td colspan="<?php echo empty($model->close_date) ? 3 : 4 ?>" style="margin-top: 5px">
                    <?php $this->renderPartial('application.views.loanApplications.saved'); ?>
                </td>
            </table>

            <?php $this->endWidget(); ?>

        </div>

    <?php endif; ?>
</div>