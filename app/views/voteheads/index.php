<?php
/* @var $this VoteheadsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Voteheads',
);

$this->menu=array(
	array('label'=>'Create Voteheads', 'url'=>array('create')),
	array('label'=>'Manage Voteheads', 'url'=>array('admin')),
);
?>

<h1>Voteheads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
