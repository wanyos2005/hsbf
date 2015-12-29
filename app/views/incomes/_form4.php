<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'expenditures-form',
        'enableAjaxValidation' => true,
        'action' => $this->createUrl('expenditures/downloadLedgerBook'),
        'htmlOptions' => array('target' => '_blank')
            )
    );
    ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Ledger Books</h3></div>
        <div class="panel-body">
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <table style="width: 100%">
                    <tr>
                        <td><b>Member :</b></td>
                        <td>
                            <?php
                            $cri = new CDbCriteria;
                            $cri->condition = '';
                            $cri->params = array();
                            $cri->order = 'last_name ASC';
                            
                            $membas[ContributionsByMembers::PAYMENT_BY_CASH]['id'] = $membas[ContributionsByMembers::PAYMENT_BY_CASH]['last_name'] = Incomes::CASH_ACCOUNT;
                            $membas[ContributionsByMembers::PAYMENT_BY_BANK]['id'] = $membas[ContributionsByMembers::PAYMENT_BY_BANK]['last_name'] = Incomes::BANK_ACCOUNT;
                            $membas['']['id'] = $membas['']['last_name'] = '';
                            
                            $members = Person::model()->findAll($cri);
                            foreach ($members as $i => $pason) {
                                $mbrshp = empty($pason->membershipno) ? null : " - $pason->membershipno";
                                $membas[$i] = $members[$i];
                                $membas[$i]->last_name = "$pason->last_name $pason->first_name $pason->middle_name$mbrshp";
                            }

                            echo CHtml::dropDownList('member', $member, CHtml::listData($membas, 'id', 'last_name'));
                            ?>
                        </td>

                        <td><b>Since :</b></td>
                        <td>
                            <?php
                            echo CHtml::textField('since', $since, array('readonly' => true, 'style' => 'text-align: center'));
                            $this->widget('application.extensions.calendar.SCalendar', array('inputField' => 'since', 'ifFormat' => '%Y-%m-%d'));
                            ?>
                        </td>

                        <td><b>Till :</b></td>
                        <td>
                            <?php
                            echo CHtml::textField('till', $till, array('readonly' => true, 'style' => 'text-align: center'));
                            $this->widget('application.extensions.calendar.SCalendar', array('inputField' => 'till', 'ifFormat' => '%Y-%m-%d'));
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel-footer clearfix">
            <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Genarate Ledger') ?></button>

            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
        </div>
    </div>

    <?php $this->endWidget(); ?>  

</div><!-- form -->