<?php

/**
 * Users module. This module handles all user management operations including<br/>
 *  acl,roles,user levels,user management
 * @author Fred <mconyango@gmail.com>
 */
class UsersModule extends CWebModule {

        public $defaultController = 'default';

        public function init()
        {
                $this->setImport(array(
                    'admin.components.*',
                ));

                parent::init();
        }

        public function beforeControllerAction($controller, $action)
        {
                if (parent::beforeControllerAction($controller, $action)) {
                        return true;
                } else
                        return false;
        }

}
