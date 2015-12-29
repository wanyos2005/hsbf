<?php
/* @var $this CashWithdrawalsController */
/* @var $model CashWithdrawals */

$this->breadcrumbs=array(
	'Cash Withdrawals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CashWithdrawals', 'url'=>array('index')),
	array('label'=>'Create CashWithdrawals', 'url'=>array('create')),
	array('label'=>'View CashWithdrawals', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashWithdrawals', 'url'=>array('admin')),
);
?>

<h1>Update CashWithdrawals <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>