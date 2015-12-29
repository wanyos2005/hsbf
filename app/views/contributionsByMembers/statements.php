<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contributions-by-members-form',
        'enableAjaxValidation' => true,
            )
    );

    $types = ContributionTypes::model()->findAll('id>1');
    ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Statements of Accounts</h3></div>
        <div class="panel-body">
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <div style="width: 100%">

                    <div style="width: 30%; float: left">
                        <table>
                            <?php foreach ($types as $type): ?>
                                <?php
                                if
                                (
                                        (
                                        $type->primaryKey != 4 &&
                                        ContributionsByMembers::model()->memberHasAContribution($user->id, $type->primaryKey)
                                        ) ||
                                        (
                                        $type->primaryKey == 4 &&
                                        LoanApplications::model()->memberHasALoan($user->id)
                                        )
                                ):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if ($type->primaryKey != 4): ?>
                                                <a class="btn btn-sm btn-primary" href="<?php echo $this->createUrl('whichStatement', array('id' => $user->id, 'type' => $type->primaryKey)) ?>" target="_blank"><i class="icon-ok bigger-110"></i><?php echo Lang::t($type->contribution_type) ?></a>
                                            <?php else: ?>
                                                <a class="btn btn-sm btn-primary"><i class="icon-ok bigger-110"></i>
                                                    <?php
                                                    echo CHtml::ajaxSubmitButton($type->contribution_type, array('loanApplications/allMembersLoans', 'member' => $user->id), array(
                                                        'update' => '#loansList',
                                                        'type' => 'submit',
                                                            ), array('id' => 'loans', 'name' => 'loans', 'style' => 'background-color: inherit; border: none')
                                                    );
                                                    ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr><td>&nbsp;</td></tr>
                                <?php endif; ?>

                            <?php endforeach; ?>

                            <?php $receipt = ContributionsByMembers::model()->find("member=:mbr && receiptno!='' && receiptno IS NOT NULL", array(':mbr' => $user->id)); ?>
                            <?php if (!empty($receipt)): ?>
                                <tr>
                                    <td>
                                        <a class="btn btn-sm btn-primary"><i class="icon-ok bigger-110"></i>
                                            <?php
                                            echo CHtml::ajaxSubmitButton('Receipt Acknowledgements', array('contributionsByMembers/myReceipts', 'id' => $user->id), array(
                                                'update' => '#loansList',
                                                'type' => 'submit',
                                                    ), array('id' => 'receipts', 'name' => 'receipts', 'style' => 'background-color: inherit; border: none')
                                            );
                                            ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                    <div id="loansList" style="width: 70%; float: right; overflow-x: hidden">

                    </div>

                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->