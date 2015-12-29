<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cash-withdrawals-form',
    'enableAjaxValidation' => true,
        ));

$attribute = $this->returnAttributes($others['authority'], $others['model']);
?>

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Savings Withdrawal Facilitation</h3></div>
    <div class="panel-body">
        <div class="col-md-8 col-sm-12" style="width: 100%">
            <div id="fomu" style="width: 100%">
                <div style="float: left; width: 60%">
                    <?php
                    if (!$others['model']->isNewRecord && !empty($model))
                        $this->renderPartial('selected_application', array(
                            'model' => $others['model'],
                            'authority' => $others['authority'],
                            'attribute' => $attribute
                                )
                        );
                    ?>
                </div>

                <div id="lists" style="float: right; width: 40%">
                    <?php
                    $this->renderPartial('applications_list', array(
                        'models' => $model,
                        'authority' => $others['authority'],
                        'attribute' => $attribute
                            )
                    );
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="panel-footer clearfix">
        <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>

        <?php if (isset($_REQUEST['id'])): ?>
            &nbsp; &nbsp; &nbsp;
            <a class="btn btn-sm btn-primary" href="<?php echo $this->createUrl('printWithdrawal', array('id' => $_REQUEST['id'])) ?>" target="_blank"><?php echo Lang::t('Print') ?></a>
        <?php endif; ?>

        &nbsp; &nbsp; &nbsp;
        <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
    </div>
</div>

<?php $this->endWidget(); ?>