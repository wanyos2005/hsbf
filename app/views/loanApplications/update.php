<?php
/* @var $this LoanApplicationsController */
/* @var $model LoanApplications */

$this->breadcrumbs=array(
	'Loan Applications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LoanApplications', 'url'=>array('index')),
	array('label'=>'Create LoanApplications', 'url'=>array('create')),
	array('label'=>'View LoanApplications', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LoanApplications', 'url'=>array('admin')),
);
?>

<h1>Update LoanApplications <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>