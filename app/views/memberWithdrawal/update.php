<?php
/* @var $this MemberWithdrawalController */
/* @var $model MemberWithdrawal */

$this->breadcrumbs=array(
	'Member Withdrawals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MemberWithdrawal', 'url'=>array('index')),
	array('label'=>'Create MemberWithdrawal', 'url'=>array('create')),
	array('label'=>'View MemberWithdrawal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MemberWithdrawal', 'url'=>array('admin')),
);
?>

<h1>Update MemberWithdrawal <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>