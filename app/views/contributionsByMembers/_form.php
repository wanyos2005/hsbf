<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contributions-by-members-form',
        'enableAjaxValidation' => true,
    ));
    ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Member payments</h3></div>
        <div class="panel-body">
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <div style="width: 100%">
                    <table>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'member'); ?></td>
                            <td>&nbsp;</td>
                            <td>
                                <?php
                                $cri = new CDbCriteria;
                                $cri->condition = '';
                                $cri->params = array();
                                $cri->order = 'last_name ASC';
                                $members = Person::model()->findAll($cri);
                                foreach ($members as $i => $member) {
                                    $mbrshp = empty($member->membershipno) ? null : " - $member->membershipno";
                                    $members[$i]->last_name = "$member->last_name $member->first_name $member->middle_name$mbrshp";
                                }
                                $members = CHtml::listData($members, 'id', 'last_name');

                                echo $form->dropDownList($model, 'member', $members, array('prompt' => '-- Select A Member --', 'required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                                        'url' => CController::createUrl('contributionsByMembers/contributionType'), 'update' => '#ContributionsByMembers_contribution_type')));
                                ?>
                            </td>
                            <td><?php echo $form->error($model, 'member'); ?></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'contribution_type'); ?></td>
                            <td>&nbsp;</td>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'contribution_type', CHtml::listData(ContributionTypes::model()->findAllByPk($model->contribution_type), 'id', 'contribution_type'), array('prompt' => $model->getAttributeLabel('contribution_type'), 'required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                                        'url' => CController::createUrl('loanApplications/loansMemberIsServicing', array('date' => $model->date)), 'update' => '#loanBalances')));
                                ?>
                            </td>
                            <td><?php echo $form->error($model, 'contribution_type'); ?></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td colspan="4" id="loanBalances">
                                <?php
                                if ($model->contribution_type == 4)
                                    $this->renderPartial('application.views.loanApplications.servicingLoans', array('model' => $others['loanRepayment'], 'loansMemberIsServicing' => $others['loansMemberIsServicing'], 'date' => $model->date));
                                else
                                if (!empty($model->contribution_type))
                                    $this->renderPartial('application.views.contributionsByMembers.amount', array('model' => $model));
                                else
                                    echo '&nbsp;';
                                ?>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'payment_mode'); ?></td>
                            <td>&nbsp;</td>
                            <td><?php echo $form->dropDownList($model, 'payment_mode', $model->paymentModes()); ?></td>
                            <td><?php echo $form->error($model, 'payment_mode'); ?></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'transaction_no'); ?></td>
                            <td>&nbsp;</td>
                            <td><?php echo $form->textField($model, 'transaction_no', array('size' => 13, 'maxlength' => 11, 'placeholder' => $model->getAttributeLabel('transaction_no'), 'required' => false, 'style' => 'text-align:center')); ?></td>
                            <td><?php echo $form->error($model, 'transaction_no'); ?></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'receiptno'); //echo Yii::getPathOfAlias('webroot').'/app/payslips/';  ?></td>
                            <td>&nbsp;</td>
                            <td><?php echo $form->textField($model, 'receiptno', array('size' => 13, 'maxlength' => 11, 'placeholder' => $model->getAttributeLabel('receiptno'), 'required' => true, 'readonly' => true, 'style' => 'text-align:center')); ?></td>
                            <td><?php echo $form->error($model, 'receiptno'); ?></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <?php if (Yii::app()->user->hasFlash('saved')): ?>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td class="flash-success" colspan="4" style="color: #00cccc">
                                    <?php echo Yii::app()->user->getFlash('saved'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>
            &nbsp; &nbsp; &nbsp;
            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->