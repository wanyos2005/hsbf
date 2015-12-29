<?php
/* @var $this KinsAndNomineesController */
/* @var $model KinsAndNominees */

$this->breadcrumbs=array(
	'Kins And Nominees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List KinsAndNominees', 'url'=>array('index')),
	array('label'=>'Manage KinsAndNominees', 'url'=>array('admin')),
);
?>


                    <?php $this->renderPartial('_form', array('models' => $models, 'jamaa' => $jamaa,)); ?>
              