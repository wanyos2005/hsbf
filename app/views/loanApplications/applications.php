<?php $attribute = $this->returnAttributes($others['authority'], $others['model']); ?>

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Loan Facilitation</h3></div>
    <div class="panel-body">
        <div class="col-md-8 col-sm-12" style="width: 100%">
            <div id="fomu" style="width: 100%">

                <?php if (!$others['model']->isNewRecord): ?>
                    <div style="float: left; width: 60%">
                        <?php
                        $this->renderPartial('selected_application', array(
                            'model' => $others['model'],
                            'authority' => $others['authority'],
                            'attribute' => $attribute
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <div id="lists" style="float: right; width: 40%">
                    <?php
                    $this->renderPartial('applications_list', array(
                        'models' => $model,
                        'authority' => $others['authority'],
                        'attribute' => $attribute
                    ));
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <a class="btn btn-sm" href="<?php echo $this->createUrl('/users/default/view', array('id' => $user->id)) ?>"><i class="icon-remove bigger-110"></i><?php echo Lang::t('Close') ?></a>
    </div>
</div>