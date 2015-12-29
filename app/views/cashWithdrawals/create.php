<?php

/* @var $this CashWithdrawalsController */
/* @var $model CashWithdrawals */

$this->breadcrumbs = array(
    'Cash Withdrawals' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List CashWithdrawals', 'url' => array('index')),
    array('label' => 'Manage CashWithdrawals', 'url' => array('admin')),
);

if (isset($readOnly))
    $this->renderPartial('_form', array('model' => $model, 'user' => $user, 'readOnly' => $readOnly));
else
    $this->renderPartial('_form', array('model' => $model, 'user' => $user));