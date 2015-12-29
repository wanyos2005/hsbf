<?php
/* @var $this CashWithdrawalsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Withdrawals',
);

$this->menu=array(
	array('label'=>'Create CashWithdrawals', 'url'=>array('create')),
	array('label'=>'Manage CashWithdrawals', 'url'=>array('admin')),
);
?>

<h1>Cash Withdrawals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
