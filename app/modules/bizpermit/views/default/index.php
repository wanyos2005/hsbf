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