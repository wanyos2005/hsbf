<?php

define('DS', DIRECTORY_SEPARATOR);
// change the following paths if necessary
$yii = dirname(__FILE__) . DS . 'app' . DS . 'lib' . DS . 'yii-1.1.14' . DS . 'framework' . DS . 'yii.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
define('PUBLIC_DIR', dirname(__FILE__) . DS . 'public');
define('APP_TEMP_DIR', PUBLIC_DIR . DS . 'temp');
date_default_timezone_set('UTC');
require_once($yii);
