<?php

Yii::import('zii.widgets.CDetailView');

/**
 * Extends CDetailView
 * @author Fred <mconyango@gmail.com>
 */
class DetailView extends CDetailView {

        /**
         * What to display when the column is null
         * @var type
         */
        public $nullDisplay = '________';

        /**
         * HTML options for the detail view container
         * @var type
         */
        public $htmlOptions = array('class' => 'table table-bordered table-condensed table-striped');

        /**
         * Style it on your own
         * @var type
         */
        public $cssFile = FALSE;

        public function init()
        {
                parent::init();
        }

        public function run()
        {
                return parent::run();
        }

}
