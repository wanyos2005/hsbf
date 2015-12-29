<?php

/**
 * Auth module (handles login, logout and password recovery)
 * @author Fred <mconyango@gmail.com>
 */
class AuthModule extends CWebModule {

        public function init()
        {
                $this->setImport(array(
                    'auth.forms.*',
                ));
        }

        public function beforeControllerAction($controller, $action)
        {
                if (parent::beforeControllerAction($controller, $action)) {
                        return true;
                } else
                        return false;
        }

}
