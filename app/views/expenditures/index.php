<?php
/* @var $this ExpendituresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Expenditures',
);

$this->menu=array(
	array('label'=>'Create Expenditures', 'url'=>array('create')),
	array('label'=>'Manage Expenditures', 'url'=>array('admin')),
);
?>

<h1>Expenditures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
