<?php

/**
 * Messaging module
 * @author  Fred<mconyango@gmail.com>
 */
class MsgModule extends CWebModule {

        public $defaultController = 'message';

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
                }
                else
                        return false;
        }

}
