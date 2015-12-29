<?php

/**
 * Department module bootstrap
 * @author Fred <mconyango@gmail.com>
 */
class DeptModule extends CWebModule {

        public $defaultController = 'default';

        public function init()
        {
                $this->setImport(array(
                    'admin.components.*',
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
