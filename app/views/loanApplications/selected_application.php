<?php
$member = Person::model()->findByPk($model->member);
$witness = Person::model()->findByPk($model->witness);

if ($model->loan_type == 4) {
    $guarantor1 = Person::model()->findByPk($model->guarantor1);
    $guarantor2 = Person::model()->findByPk($model->guarantor2);
}

$address = PersonAddress::model()->find('person_id=:id', array(':id' => $model->member));
$loan = Loans::model()->findByPk($model->loan_type);
$contributions = ContributionsByMembers::model()->netTotalMemberContribution($model->member, date('Y') . '-' . date('m') . '-' . date('d'));
?>
<div style="height: 400px; border-right: 3px solid #4f99c6">

    <?php if ($model->closed != 'Yes' && empty($model->close_date)): ?>
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

                <tr>
                    <td><b>Type of Loan : </b></td>
                    <td><?php echo "$loan->loan_type"; ?></td>
                    <td><b>Date : </b></td>
                    <td><?php echo "$model->witness_date"; ?></td>
                </tr>

                <tr>
                    <td><b>Amount Applied : </b></td>
                    <td><?php echo "KShs. $model->amout_borrowed"; ?></td>
                    <td><b>Repayment Period : </b></td>
                    <td><?php echo "$model->repayment_period Months"; ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2"><b>Total Contributions : </b></td>
                    <td colspan="2"><?php echo "KShs. $contributions"; ?></td>
                </tr>

                <tr>
                    <td><b>Present Net Pay : </b></td>
                    <td><?php echo "KShs. $model->present_net_pay"; ?></td>
                    <td><b>Final Net Pay : </b></td>
                    <td><?php echo "KShs. $model->net_pay_after_loan_repayment"; ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td></td>
                    <td style="text-align: center" colspan="2"><b>Name</b></td>
                    <td style="text-align: center"><b>Payroll No.</b></td>
                </tr>

                <tr>
                    <td><b>Witness : </b></td>
                    <td colspan="2"><?php echo "$witness->last_name $witness->first_name $witness->middle_name"; ?></td>
                    <td style="text-align: center"><?php echo "$witness->payrollno"; ?></td>
                </tr>

                <?php if ($model->loan_type == 4): ?>
                    <tr>
                        <td><b>Guarantor 1 : </b></td>
                        <td colspan="2"><?php echo "$guarantor1->last_name $guarantor1->first_name $guarantor1->middle_name"; ?></td>
                        <td style="text-align: center"><?php echo "$guarantor1->payrollno"; ?></td>
                    </tr>

                    <tr>
                        <td><b>Guarantor 2 : </b></td>
                        <td colspan="2"><?php echo "$guarantor2->last_name $guarantor2->first_name $guarantor2->middle_name"; ?></td>
                        <td style="text-align: center"><?php echo "$guarantor2->payrollno"; ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="4">
                        <?php
                        if (!empty($model->payslip) && file_exists($payslip = Yii::app()->basePath . "\payslips\\$model->payslip")) {
                            echo CHtml::image(MyYiiUtils::getThumbSrc($payslip, array('resize' => array('width' => 500))), CHtml::encode('Payslip Not Found'), array('style' => 'text-align: center; border: 3px solid #C9E0ED; border-radius: 6px', 'id' => 'avator', 'class' => 'editable img-responsive'));
                            echo '<br/>';
                        }
                        ?>
                    </td>
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
                                    'url' => CController::createUrl('loanApplications/save'), 'update' => '#render')));
                            ?>
                        </td>

                        <?php if (!empty($model->$attribute['date'])): ?>
                            <td><?php echo 'On ' . $model->$attribute['date']; ?></td>
                        <?php endif; ?>
                    </tr>

                    <?php if ($authority == 'chairman'): ?>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="2"><?php echo $form->labelEx($model, 'closed'); ?></td>
                            <td colspan="1">
                                <?php
                                echo $form->dropDownList($model, 'closed', array('Yes' => 'Yes', 'No' => 'No'), array('required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                                        'url' => CController::createUrl('loanApplications/save'), 'update' => '#render')));
                                ?>
                            </td>

                            <?php if (!empty($model->close_date)): ?>
                                <td><?php echo "On $model->close_date"; ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>

                <td colspan="<?php echo empty($model->close_date) ? 4 : 5 ?>" style="margin-top: 5px">
                    <?php $this->renderPartial('saved'); ?>
                </td>
            </table>

            <?php $this->endWidget(); ?>

        </div>
    <?php endif; ?>
</div>