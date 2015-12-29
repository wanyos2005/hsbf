<?php

/**
 * Wrapper class for implementing colorbox form operations;
 * @author Fred <mconyango@gmail.com>
 */
class MyColorbox extends CWidget {

        /**
         * The jquery form selector e.g "#formID"
         * @var type
         */
        public $FormSelector;

        /**
         * The container of all notification as a result to form processing e.g success or input errors
         * @var type
         */
        public $NotificationContainerSelector = '#my-colorbox-notif';

        /**
         * Error css class
         * @var type
         */
        public $SuccessClass = 'alert-success';

        /**
         * Success css class
         * @var type
         */
        public $ErrorClass = 'alert-danger';

        /**
         *
         * @var type
         */
        private $my_assets_base_url;

        public function init()
        {
                parent::init();
        }

        public function run()
        {
                $this->registerAssets();
        }

        protected function registerAssets()
        {
                //register scripts
                $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
                $this->my_assets_base_url = Yii::app()->assetManager->publish($assets);
                Yii::app()->clientScript
                        ->registerScriptFile($this->my_assets_base_url . '/mycolorbox.js', CClientScript::POS_END)
                        ->registerScript('_my_colorbox_form_', "
                                $.fn.mycolorbox({notificationContainerSelector:'" . $this->NotificationContainerSelector . "',formSelector:'" . $this->FormSelector . "',successClass:'" . $this->SuccessClass . "',errorClass:'" . $this->ErrorClass . "'});
                        ");
        }

}
