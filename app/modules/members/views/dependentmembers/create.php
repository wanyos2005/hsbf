<?php
$this->breadcrumbs = array(
    'Dependent Members' => array('index'),
    $jamaa->name,
);

$this->menu = array(
    array('label' => 'List DependentMembers', 'url' => array('index')),
    array('label' => 'Manage DependentMembers', 'url' => array('admin')),
);

switch ($_REQUEST['rltn1']) {
    case 1: $dependent = 'Parents';
        break;
    case 2: $dependent = 'Parents-in-Law';
        break;
    case 3: $dependent = 'Siblings';
        break;
    case 4: $dependent = 'Spouse';
        break;
    case 5: $dependent = 'Children';
        break;

    default:
        $dependent = null;
        break;
}
?>


                    <?php $this->renderPartial('_form', array('models' => $models, 'jamaa' => $jamaa, 'dependent' => $dependent)); ?>