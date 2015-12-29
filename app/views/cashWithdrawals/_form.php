<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'cash-withdrawals-form',
        'enableAjaxValidation' => true,
    ));

    $member = Person::model()->findByPk($model->member);
    $name = "$member->last_name $member->first_name $member->middle_name - $member->membershipno";
    $readOnly = isset($readOnly) ? $readOnly : $model->member != $user->primaryKey || $model->received_by_secretary != CashWithdrawals::PENDING || $model->approved_by_chairman != CashWithdrawals::PENDING || $model->effected_by_treasurer != CashWithdrawals::PENDING || !empty($model->secretary_date) || !empty($model->chairman_date) || !empty($model->treasurer_date) ? true : false;

    $officio = Maofficio::model()->officio();
    ?>

    <?php if (!isset($_REQUEST['id'])): ?>
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Savings Withdrawal</h3></div>
            <div class="panel-body">
                <div class="col-md-8 col-sm-12" style="width: 100%">
                    <div id="fomu" style="width: 100%">
                    <?php endif; ?>

                    <table style="width: 100%">
                        <tr>
                            <td><?php echo $form->labelEx($model, 'member'); ?></td>
                            <td colspan="2"><?php echo CHtml::textField('name', $name, array('size' => strlen($name) + 4, 'readonly' => true, 'style' => 'text-align:center')); ?></td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'cash_or_cheque'); ?></td>
                            <td><?php echo $readOnly == true ? $form->textField($model, 'cash_or_cheque', array('size' => 7, 'maxlength' => 7, 'readonly' => $readOnly, 'required' => true)) : $form->dropDownList($model, 'cash_or_cheque', CashWithdrawals::model()->cashOrCheque(), array('prompt' => '-- Cash / Cheque --', 'readonly' => $readOnly, 'required' => true)); ?></td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td><?php echo $form->labelEx($model, 'amount'); ?></td>
                            <td><?php echo $form->textField($model, 'amount', array('size' => 11, 'maxlength' => 11, 'numeric' => true, 'readonly' => $readOnly, 'required' => true)); ?></td>
                            <td><?php echo $form->error($model, 'amount'); ?></td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>

                        <?php if (!empty($officio)): ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $form->labelEx($model, 'received_by_secretary');
                                    echo CHtml::hiddenField('secretary_date', $model->secretary_date);
                                    echo CHtml::hiddenField('received_by_secretary', $model->received_by_secretary);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $officio != 'secretary' || $model->approved_by_chairman != CashWithdrawals::PENDING || $model->effected_by_treasurer != CashWithdrawals::PENDING || !empty($model->chairman_date) || !empty($model->treasurer_date) ? true : false ?
                                                    $form->textField($model, 'received_by_secretary', array('readonly' => true, 'style' => 'text-align:center')) :
                                                    $form->dropDownList($model, 'received_by_secretary', CashWithdrawals::model()->approveOrOtherwise(), array('required' => true, 'ajax' => array('type' => 'POST',
                                                            'url' => CController::createUrl('cashWithdrawals/secDate'), 'update' => '#secdate')));
                                    ?>
                                </td>
                                <td id="secdate">
                                    <?php
                                    if (!empty($model->secretary_date))
                                        echo $form->textField($model, 'secretary_date', array('readonly' => true, 'style' => 'text-align:center'));
                                    ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td>
                                    <?php
                                    echo $form->labelEx($model, 'approved_by_chairman');
                                    echo CHtml::hiddenField('chairman_date', $model->chairman_date);
                                    echo CHtml::hiddenField('approved_by_chairman', $model->approved_by_chairman);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $officio != 'chairman' || $model->received_by_secretary != CashWithdrawals::YES || $model->effected_by_treasurer != CashWithdrawals::PENDING || empty($model->secretary_date) || !empty($model->treasurer_date) ? true : false ?
                                                    $form->textField($model, 'approved_by_chairman', array('readonly' => true, 'style' => 'text-align:center')) :
                                                    $form->dropDownList($model, 'approved_by_chairman', CashWithdrawals::model()->approveOrOtherwise(), array('required' => true, 'ajax' => array('type' => 'POST',
                                                            'url' => CController::createUrl('cashWithdrawals/chairDate'), 'update' => '#chairDate')));
                                    ?>
                                </td>
                                <td id="chairDate">
                                    <?php
                                    if (!empty($model->chairman_date))
                                        echo $form->textField($model, 'chairman_date', array('readonly' => true, 'style' => 'text-align:center'));
                                    ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td>
                                    <?php
                                    echo $form->labelEx($model, 'effected_by_treasurer');
                                    echo CHtml::hiddenField('treasurer_date', $model->treasurer_date);
                                    echo CHtml::hiddenField('effected_by_treasurer', $model->effected_by_treasurer);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $officio != 'treasurer' || $model->effected_by_treasurer == CashWithdrawals::YES || $model->received_by_secretary != CashWithdrawals::YES || $model->approved_by_chairman != CashWithdrawals::YES || empty($model->secretary_date) || empty($model->chairman_date) ? true : false ?
                                                    $form->textField($model, 'effected_by_treasurer', array('readonly' => true, 'style' => 'text-align:center')) :
                                                    $form->dropDownList($model, 'effected_by_treasurer', CashWithdrawals::model()->approveOrOtherwise(), array('required' => true, 'ajax' => array('type' => 'POST',
                                                            'url' => CController::createUrl('cashWithdrawals/pesaDate'), 'update' => '#pesaDate')));
                                    ?>
                                </td>
                                <td id="pesaDate">
                                    <?php
                                    if (!empty($model->treasurer_date))
                                        echo $form->textField($model, 'treasurer_date', array('readonly' => true, 'style' => 'text-align:center'));
                                    ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>
                        <?php endif; ?>

                        <tr>
                            <td colspan="3"><?php $this->renderPartial('application.views.loanApplications.saved'); ?> </td>
                        </tr>

                    </table>

                    <?php if (!isset($_REQUEST['id'])): ?>
                    </div>
                </div>
            </div>

            <div class="panel-footer clearfix">
                <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>

                <?php if (!$model->isNewRecord): ?>
                    &nbsp; &nbsp; &nbsp;
                    <a class="btn btn-sm btn-primary" href="<?php echo $this->createUrl('printWithdrawal', array('id' => $model->id)) ?>" target="_blank"><?php echo Lang::t('Print') ?></a>
                <?php endif; ?>

                &nbsp; &nbsp; &nbsp;
                <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
            </div>
        </div>
    <?php endif; ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->