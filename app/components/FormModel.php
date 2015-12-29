<?php

/**
 * Extension of the @link CFormModel
 * @author Fred <mconyango@gmail.com>
 */
abstract class FormModel extends CFormModel {

        /**
         * Class name of the form model
         * @return string Class name
         */
        public function getClassName()
        {
                return get_class($this);
        }

}
