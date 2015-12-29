<?php
/* @var $this FunzoPersonalDetailsController */
/* @var $model FunzoPersonalDetails */

$this->breadcrumbs=array(
	'Funzo Personal Details'=>array('index'),
	$model->APP_ID=>array('view','id'=>$model->APP_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List FunzoPersonalDetails', 'url'=>array('index')),
	array('label'=>'Create FunzoPersonalDetails', 'url'=>array('create')),
	array('label'=>'View FunzoPersonalDetails', 'url'=>array('view', 'id'=>$model->APP_ID)),
	array('label'=>'Manage FunzoPersonalDetails', 'url'=>array('admin')),
);
?>

<h1>Update FunzoPersonalDetails <?php echo $model->APP_ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>