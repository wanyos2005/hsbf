<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'member-withdrawal-form',
        'enableAjaxValidation' => false,
    ));

    $array = array('Yes' => 'Retain Membership', 'Pending' => 'Withdraw Membership');
    ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Membership Withdrawal</h3></div>
        <div class="panel-body">
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <div id="fomu" style="width: 100%; overflow-x: hidden">

                    <?php if ($others['readOnly'] == true): ?>
                        Your withdrawal is pending approval:
                    <?php else: ?>
                        You may choose to withdraw or retain your membership:
                    <?php endif; ?>

                    <table style="width: 100%">
                        <tr>
                            <td><?php echo $form->labelEx($model, 'status') ?></td>
                            <td>
                                <?php
                                if ($others['readOnly'] == true)
                                    echo $form->textField($model, 'status', array('value' => $model->status == 'Yes' ? 'Member' : $model->status, 'required' => true, 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
                                else {
                                    echo $form->dropDownList($model, 'status', $array, array('prompt' => '-- Select An Option --', 'required' => true, 'style' => 'text-align:center', 'ajax' => array('type' => 'POST',
                                            'url' => CController::createUrl('memberWithdrawal/renderPartialForm'), 'update' => '#fomu')));

                                    echo $form->hiddenField($model, 'member');
                                }
                                ?>
                            </td>
                            <td>&nbsp;<?php echo $form->error($model, 'status'); ?></td>
                        </tr>
                    </table>

                    <?php $this->renderPartial('application.views.loanApplications.saved'); ?>

                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->