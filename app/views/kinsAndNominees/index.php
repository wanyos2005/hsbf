<?php
/* @var $this KinsAndNomineesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kins And Nominees',
);

$this->menu=array(
	array('label'=>'Create KinsAndNominees', 'url'=>array('create')),
	array('label'=>'Manage KinsAndNominees', 'url'=>array('admin')),
);
?>

<h1>Kins And Nominees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
