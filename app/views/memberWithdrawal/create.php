<?php
/* @var $this MemberWithdrawalController */
/* @var $model MemberWithdrawal */

$this->breadcrumbs = array(
    'Member Withdrawals' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List MemberWithdrawal', 'url' => array('index')),
    array('label' => 'Manage MemberWithdrawal', 'url' => array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model' => $model, 'others' => $others, 'user' => $user)); ?>