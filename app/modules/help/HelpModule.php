<?php

/**
 * Help module will hold all help actions
 * @author Fred <mconyango@gmail.com>
 */
class HelpModule extends CWebModule {

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
                }
                else
                        return false;
        }

}
