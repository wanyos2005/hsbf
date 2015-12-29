<?php

/**
 * stores all the site-wide configurations
 * @author Fredrick <mconyango@gmail.com>
 * @version 1.0
 */
// Yii::setPathOfAlias('local','path/to/local-folder');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'SMART COUNTY',
    'language' => 'en',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => require(dirname(__FILE__) . '/import.php'),
    //available modules
    'modules' => require(dirname(__FILE__) . '/modules.php'),
    // application components
    'components' => array(
        'cache' => array(
            'class' => 'system.caching.CFileCache',
            'enabled' => TRUE,
        ),
        'settings' => array(
            'class' => 'CmsSettings',
            'cacheComponentId' => 'cache',
            'cacheId' => 'global_website_settings',
            'cacheTime' => 84000,
            'tableName' => '{{settings}}',
            'dbComponentId' => 'db',
            'createTable' => false,
            'dbEngine' => 'InnoDB',
        ),
        'urlManager' => array(
            'class' => 'UrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => true,
            'urlSuffix' => '',
            'rules' => array(
                '<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
            /* '<controller:\w+>/<action:\w+>'=>'<controller>/<action>', */
            ),
        ),
        //database settings
        'db' => require(dirname(__FILE__) . '/db.php'),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning,info',
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => false,
                ),
            ),
        ),
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
            'driver' => 'GD',
            'quality' => 100,
            'cachePath' => '/assets/easyimage/',
            'cacheTime' => 2592000,
            'retinaSupport' => false,
        ),
        'localtime' => array(
            'class' => 'application.components.LocalTime',
        ),
        'mailer' => require(dirname(__FILE__) . '/email.php'),
    ),
);
