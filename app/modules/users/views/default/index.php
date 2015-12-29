<?php
if (empty($dept_model)):
    $this->breadcrumbs = array(
        $this->pageTitle,
    );
else:
    $this->breadcrumbs = array(
        Lang::t('Departments') => Yii::app()->createUrl('dept/default/index'),
        CHtml::encode($dept_model->name) => Yii::app()->createUrl('dept/default/view', array('id' => $dept_model->id)),
        CHtml::encode($this->pageDescription),
    );
endif;
?>
<?php if (!empty($dept_model)): ?>
    <div class="tabbable">
        <?php $this->renderPartial('dept.views.default._tabs', array('model' => $dept_model)); ?>

        <div class="tab-content no-border padding-24">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <?php $this->renderPartial('_grid', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php $this->renderPartial('_grid', array('model' => $model)); ?>
<?php endif; ?>