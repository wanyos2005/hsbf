<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bootstrap.php');
$config = dirname(__FILE__) . DS . 'app' . DS . 'config' . DS . 'main.php';
Yii::createWebApplication($config)->run();
