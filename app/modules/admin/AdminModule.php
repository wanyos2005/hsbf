<?php

/**
 * Administrator module: Should only be accessed by the site admins
 * @author mconyango<mconyango@gmail.com>
 */
class AdminModule extends CWebModule {

        const MODULE_KEY = 'admin';

        public $defaultController = 'default';

        public function init()
        {
                parent::init();
                //module specific classes
                $this->setImport(array(
                    'admin.models.*',
                    'admin.models.forms.*',
                    'admin.components.*',
                ));

                //module based componets
                $this->setComponents(array(
                    'user' => array(
                        'class' => 'CWebUser',
                        'loginUrl' => Yii::app()->createUrl('auth/login'),
                        'allowAutoLogin' => true,
                        'autoRenewCookie' => true,
                        'authTimeout' => 31557600,
                        'returnUrl' => Yii::app()->createUrl(self::MODULE_KEY . '/default/index'),
                    ),
                ));
        }

        public function beforeControllerAction($controller, $action)
        {
                if (parent::beforeControllerAction($controller, $action)) {
                        $route = $controller->id . '/' . $action->id;
                        $publicPages = array(
                            'auth/login',
                            'auth/forgotPassword',
                            'auth/resetPassword',
                            'error/index',
                        );
                        if (Yii::app()->user->isGuest && !in_array($route, $publicPages)) {
                                Yii::app()->getModule(self::MODULE_KEY)->user->loginRequired();
                        }
                        else
                                return true;
                }
                else
                        return false;
        }

}
