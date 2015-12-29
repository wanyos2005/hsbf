<?php
/* @var $this MaofficioController */
/* @var $model Maofficio */

$this->breadcrumbs=array(
	'Maofficios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Maofficio', 'url'=>array('index')),
	array('label'=>'Manage Maofficio', 'url'=>array('admin')),
);
?>

<h1>Create Maofficio</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>