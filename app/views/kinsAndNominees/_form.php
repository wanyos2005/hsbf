<?php
/* @var $this KinsAndNomineesController */
/* @var $model KinsAndNominees */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'kins-and-nominees-form',
        'enableAjaxValidation' => true,
    ));

    $i = 0;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><?php echo Lang::t($_REQUEST['kiNom'] == 'kin' ? KinsAndNominees::NEXT_OF_KIN . 's' : KinsAndNominees::NOMINEE . 's') ?></h3></div>
        <div class="panel-body">
            <!--  <div class="row" style="overflow-x: scroll"> -->
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <div style="width: 100%">
                    <table style="width: 100%; text-align: center">
                        <tr style="font-weight: bold">
                            <td>No.</td>
                            <td>Name</td>
                            <td>ID. No.</td>
                            <td>Relationship</td>
                            <td>Mobile No.</td>
                            <td>Status</td>

                            <?php if ($_REQUEST['kiNom'] == 'nom'): ?>
                                <td>Percent</td>
                            <?php endif; ?>
                        </tr>

                        <?php
                        foreach ($models as $m => $model):
                            $dependent = DependentMembers::model()->findByPk($model->dependent_member);
                            $rltnship = Relationships::model()->returnRelationship($dependent->relationship);
                            ?>
                            <tr>
                                <td style="text-align: center"><?php echo ++$i; ?>. </td>
                                <td style="text-align: left"><?php echo $dependent->name; ?></td>
                                <td><?php echo $dependent->idno; ?></td>
                                <td><?php echo $rltnship; ?></td>
                                <td><?php echo $dependent->mobileno; ?></td>
                                <td>
                                    <?php
                                    echo $form->dropDownList($model, "[$model->dependent_member]active", array(
                                        KinsAndNominees::ACTIVE => KinsAndNominees::ACTIVE, KinsAndNominees::INACTIVE => KinsAndNominees::INACTIVE
                                            ), array('required' => true, 'ajax' => array('type' => 'POST',
                                            'url' => CController::createUrl('kinsAndNominees/pasent', array('member' => $model->dependent_member, 'kiNom' => $_REQUEST['kiNom'])), 'update' => "#pasent$model->dependent_member")
                                            )
                                    );
                                    ?>
                                </td>

                                <?php if ($_REQUEST['kiNom'] == 'nom'): ?>
                                    <td id=<?php echo "pasent$model->dependent_member" ?>><?php echo $form->textField($model, "[$model->dependent_member]percent", array('size' => 5, 'maxlength' => 5, 'numeric' => true, 'style' => 'text-align:center', 'readonly' => $model->active == KinsAndNominees::ACTIVE && $model->kinOrNominee == KinsAndNominees::NOMINEE ? false : true, 'required' => $model->active == KinsAndNominees::ACTIVE && $model->kinOrNominee == KinsAndNominees::NOMINEE ? true : false)); ?></td>
                                <?php endif; ?>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                        <?php endforeach; ?>

                    </table>

                    <!--  </div> -->
                </div>
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
                    ?>"><?php echo Lang::t('Next Of Kins') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php elseif (isset($_REQUEST['kiNom']) && $_REQUEST['kiNom'] = 'nom'): ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/users/default/view', array('id' => $jamaa->id, 'action' => Users::ACTION_UPDATE_PERSONAL))
                    ?>"><?php echo Lang::t('Continue') ?> <i class="fa fa-chevron-right"></i></a>
                   <?php else: ?>
                    <a class="pull-right btn btn-sm btn-primary" href="<?php
                    echo $this->createUrl('/kinsAndNominees/create', array('id' => $jamaa->id,
                        'kiNom' => $rltn = 'nom', 'action' => Users::ACTION_ADD_DEPENDENTS))
                    ?>"><?php echo Lang::t('Nominees') ?> <i class="fa fa-chevron-right"></i></a>
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
                    ?>"><i class="fa fa-chevron-left"></i> <?php echo Lang::t('Address Information') ?></a>
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

</div><!-- form -->