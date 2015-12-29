<?php
/* @var $this MaofficioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Maofficios',
);

$this->menu=array(
	array('label'=>'Create Maofficio', 'url'=>array('create')),
	array('label'=>'Manage Maofficio', 'url'=>array('admin')),
);
?>

<h1>Maofficios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
