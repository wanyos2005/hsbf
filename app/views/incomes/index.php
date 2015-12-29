<?php
/* @var $this IncomesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Incomes',
);

$this->menu=array(
	array('label'=>'Create Incomes', 'url'=>array('create')),
	array('label'=>'Manage Incomes', 'url'=>array('admin')),
);
?>

<h1>Incomes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
