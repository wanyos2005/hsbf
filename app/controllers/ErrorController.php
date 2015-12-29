<?php

/**
 * @author Fred<mconyango@gmail.com>
 */
class ErrorController extends Controller {

        public function init()
        {
                $this->layout = FALSE;
                parent::init();
        }

        /**
         * This is the action to handle external exceptions.
         */
        public function actionIndex()
        {
                if ($error = Yii::app()->errorHandler->error) {
                        if (Yii::app()->request->isAjaxRequest)
                                echo strip_tags($error['message']);
                        else {
                                $this->render('index', array(
                                    'error' => $error,
                                ));
                        }
                }
        }

}
