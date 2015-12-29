<?php
/* @var $this ExpendituresController */
/* @var $income Expenditures */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'expenditures-form',
        'enableAjaxValidation' => true,
    ));
    ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Record Income And Expenditure</h3></div>
        <div class="panel-body">
            <div class="col-md-8 col-sm-12" style="width: 100%">
                <?php $field = Voteheads::INCOME; ?>
                <div id="<?php echo "div$field" ?>" style="width: 47%; float: left">
                    <?php
                    $this->renderPartial('fieldsTable', array(
                        'form' => $form, 'model' => $income, 'heading' => Voteheads::INCOME_HEADING, 'user' => $user,
                        'field' => $field, 'fieldType' => Voteheads::SELECT
                            )
                    );
                    ?>
                </div>

                <?php $field = Voteheads::EXPENSE; ?>
                <div id="<?php echo "div$field" ?>" style="width: 50%; float: right; border-left: 2px solid #000000; padding-left: 15px">
                    <?php
                    $this->renderPartial('fieldsTable', array(
                        'form' => $form, 'model' => $expenditure, 'heading' => Voteheads::EXPENSE_HEADING, 'user' => $user,
                        'field' => $field, 'fieldType' => Voteheads::SELECT
                            )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <!--
            <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>
            &nbsp; &nbsp; &nbsp;
            -->
            <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
        </div>
    </div>

    <?php $this->endWidget(); ?>  

</div><!-- form -->