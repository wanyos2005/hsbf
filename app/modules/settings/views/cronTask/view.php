<?php
/* @var $this CronTaskController */
/* @var $model ConsoleTasks */

$this->breadcrumbs = array(
    'Cron Tasks' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List CronTasks', 'url' => array('index')),
    array('label' => 'Create CronTasks', 'url' => array('create')),
    array('label' => 'Update CronTasks', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete CronTasks', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CronTasks', 'url' => array('admin')),
);
?>

<h1>View CronTasks #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'last_run',
        'status',
        'threads',
        'max_threads',
        'sleep',
    ),
));
?>
