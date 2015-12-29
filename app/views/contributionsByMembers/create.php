<?php
/* @var $this ContributionsByMembersController */
/* @var $model ContributionsByMembers */

$this->breadcrumbs = array(
    'Contributions By Members' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List ContributionsByMembers', 'url' => array('index')),
    array('label' => 'Manage ContributionsByMembers', 'url' => array('admin')),
);
?>

<?php
$this->renderPartial('_form', array('model' => $model, 'user' => $user, 'others' => $others));
