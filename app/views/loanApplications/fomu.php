<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'loan-applications-form',
    'enableAjaxValidation' => true,
        )
);
?>

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Loan Application</h3></div>
    <div class="panel-body">
        <div class="col-md-8 col-sm-12" style="width: 100%">
            <div id="fomu" style="width: 100%; overflow-x: hidden">

                <?php
                $this->renderPartial('saved');
                $this->renderPartial('table', array('model' => $model, 'others' => $others, 'form' => $form));
                ?>

            </div>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <button class="btn  btn-sm btn-primary" type="submit"><i class="icon-ok bigger-110"></i> <?php echo Lang::t('Save changes') ?></button>

        <?php if (!$model->isNewRecord): ?>
            &nbsp; &nbsp; &nbsp;
            <a class="btn btn-sm btn-primary" href="<?php echo $this->createUrl('printLoan', array('id' => $model->id)) ?>" target="_blank"><?php echo Lang::t('Print') ?></a>
        <?php endif; ?>

        &nbsp; &nbsp; &nbsp;
        <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
    </div>
</div>

<?php
$this->endWidget();
