<?php
/* @var $this LoanApplicationsController */
/* @var $model LoanApplications */

$this->breadcrumbs = array(
    'Loan Applications' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List LoanApplications', 'url' => array('index')),
    array('label' => 'Manage LoanApplications', 'url' => array('admin')),
);
?>

<?php
$this->renderPartial('_form', array('model' => $model, 'others' => $others, 'user' => $user));
