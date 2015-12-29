<?php
/* @var $this DependentMembersController */
/* @var $model DependentMembers */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dependent-members-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><?php echo Lang::t("Dependent Members - $dependent") ?></h3></div>
        <div class="panel-body">
            <!--  <div class="row" style="overflow-x: scroll"> -->
            <div class="col-md-8 col-sm-12">
                <div style="width: 100%">

                    <table style="width: 100%">
                        <tr style="text-align: center; font-weight: bold">
                            <td style="text-align: right">
                                NO
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('name'); ?>
                            </td>
                            <?php if ($_REQUEST['rltn1'] == 5): ?>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo DependentMembers::model()->getAttributeLabel('dob'); ?>
                                </td>
                            <?php endif; ?>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('idno'); ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('alive'); ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('relationship'); ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('mobileno'); ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo DependentMembers::model()->getAttributeLabel('postaladdress'); ?>
                            </td>
                        </tr>

                        <?php
                        $c = 0;
                        foreach ($models as $i => $model):
                            ?>
                            <tr>
                                <td style="text-align: right">
                                    <?php echo ++$c; ?>.&nbsp;

                                </td>
                                <td>
                                    <?php echo $form->textField($model, "[$i]name", array('size' => 25, 'maxlength' => 30, 'placeholder' => $model->getAttributeLabel('name'))); ?>
                                </td>
                                <?php if ($_REQUEST['rltn1'] == 5): ?>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        <?php
                                        echo $form->textField($model, "[$i]dob", array('id' => "[$i]dob", 'size' => 10, 'maxlength' => 10, 'readOnly' => true, 'placeholder' => $model->getAttributeLabel('dob')));
                                        $this->widget('ext.calendar.SCalendar', array('inputField' => "[$i]dob", 'ifFormat' => '%Y-%m-%d'));
                                        ?>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->textField($model, "[$i]idno", array('size' => 8, 'maxlength' => 15, 'placeholder' => $model->getAttributeLabel('idno'))); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->dropDownlist($model, "[$i]alive", array('0' => 'No', '1' => 'Yes'), array()); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php
                                    if ($_REQUEST['rltn1'] == 4)
                                        $model->relationship = $jamaa->gender == 'Male' ? 9 : 4;

                                    $rln1 = $_REQUEST['rltn1'] == 4 && $jamaa->gender == 'Male' ? $_REQUEST['rltn2'] : $_REQUEST['rltn1'];
                                    $rln2 = $_REQUEST['rltn1'] == 4 && $jamaa->gender == 'Female' ? $_REQUEST['rltn1'] : $_REQUEST['rltn2'];

                                    $cri = new CDbCriteria;
                                    $cri->condition = 'id=:id1 || id=:id2';
                                    $cri->params = array(':id1' => $rln1, ':id2' => $rln2);
                                    $cri->order = 'relationship ASC';
                                    $rlns = Relationships::model()->findAll($cri);

                                    $rlns = CHtml::listData($rlns, 'id', 'relationship');
                                    ?>
                                    <?php echo $form->dropDownList($model, "[$i]relationship", $rlns, array()); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->textField($model, "[$i]mobileno", array('size' => 10, 'maxlength' => 10, 'placeholder' => $model->getAttributeLabel('mobileno'))); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->textField($model, "[$i]postaladdress", array('size' => 30, 'maxlength' => 128, 'placeholder' => $model->getAttributeLabel('postaladdress'))); ?>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]name"); ?>
                                </td>
                                <?php if ($_REQUEST['rltn1'] == 5): ?>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        <?php echo $form->error($model, "[$i]dob"); ?>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]idno"); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]alive"); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]relationship"); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]mobileno"); ?>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <?php echo $form->error($model, "[$i]postaladdress"); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
<!--  <tr>
<td></td>
<td style="text-align: left">
                        <?php echo CHtml::submitButton('Save'); ?></td>
                        <?php if ($_REQUEST['rltn1'] == 5): ?>
                                <td></td>
                                <td></td>
                        <?php endif; ?>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr> -->
                    </table>


                </div>
                <!--  </div> -->
            </div>
        </div>

        <div class="panel-footer clearfix">
            <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>
            &nbsp; &nbsp; &nbsp;
            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $jamaa->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>


            <?php if (isset($_REQUEST['rltn1']) || isset($_REQUEST['kiNom'])): ?>
                <?php if (isset($_REQUEST['rltn1']) && $_REQUEST['rltn1'] != 3): ?>    
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/members/dependentMembers/create', array('id' => $jamaa->id,
                        'rltn1' => $m = $_REQUEST['rltn1'] == 4 ? ($jamaa->havechildren == 'y' ? 5 : 1) : ($_REQUEST['rltn1'] == 5 ? 1 : ($_REQUEST['rltn1'] == 1 ? 2 : 3)),
                        'rltn2' => $m + 5, 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php elseif (isset($_REQUEST['rltn1'])): ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/kinsAndNominees/create', array('id' => $jamaa->id,
                        'kiNom' => $rltn = 'kin', 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php elseif (isset($_REQUEST['kiNom']) && $_REQUEST['kiNom'] = 'nom'): ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/users/default/view', array('id' => $jamaa->id, 'action' => Users::ACTION_UPDATE_PERSONAL))
                    ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php else: ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/kinsAndNominees/create', array('id' => $jamaa->id,
                        'kiNom' => $rltn = 'nom', 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php endif; ?>

                <a class="pull-right" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</a>

                <?php if ((isset($_REQUEST['kiNom']) && $_REQUEST['kiNom'] == 'kin') || (isset($_REQUEST['rltn1']) && (($_REQUEST['rltn1'] != 4 || ($_REQUEST['rltn1'] == 5 && $jamaa->married == 'y') || ($_REQUEST['rltn1'] == 1 && ($jamaa->married == 'y' || $jamaa->havechildren == 'y')))))): ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/members/dependentMembers/create', array('id' => $jamaa->id,
                        'rltn1' => $rltn = isset($_REQUEST['kiNom']) && $_REQUEST['kiNom'] == 'kin' ? 3 : ($m = $_REQUEST['rltn1'] == 3 ? 2 : ($_REQUEST['rltn1'] == 2 ? 1 : ($_REQUEST['rltn1'] == 5 ? 4 : ($jamaa->havechildren == 'y' ? 5 : 4) ) ) ),
                        'rltn2' => $m + 5, 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><i class="fa fa-chevron-left"></i> <?php echo Lang::t('Back') ?></a>
                   <?php elseif (isset($_REQUEST['rltn1'])): ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/users/default/view', array('id' => $jamaa->id, 'action' => Users::ACTION_UPDATE_ADDRESS))
                    ?>"><i class="fa fa-chevron-left"></i> <?php echo Lang::t('Back') ?></a>
                   <?php else: ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/kinsAndNominees/create', array('id' => $jamaa->id,
                        'kiNom' => $rltn = 'kin', 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><i class="fa fa-chevron-left"></i> <?php echo Lang::t('Back') ?></a>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
    <?php $this->endWidget(); ?>

</div>

<!-- form -->