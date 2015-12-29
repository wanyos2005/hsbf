<?php
/* @var $this LoanApplicationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Loan Applications',
);

$this->menu=array(
	array('label'=>'Create LoanApplications', 'url'=>array('create')),
	array('label'=>'Manage LoanApplications', 'url'=>array('admin')),
);
?>

<h1>Loan Applications</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
