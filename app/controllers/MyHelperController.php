<?php

/**
 * All shared Helper actions
 * @author mconyango
 */
class MyHelperController extends Controller {

        /**
         * Fineuploader action
         * @link http://fineuploader.com
         */
        public function actionFineUploader($file_name = null)
        {
                Yii::import("ext.EAjaxUpload.qqFileUploader");
                $uploader = new qqFileUploader();
                $uploader->chunksFolder = Common::createDir(APP_TEMP_DIR);
                $base_dir = Common::createDir(APP_TEMP_DIR . DS . $_POST['qquuid']);

                if (isset($_POST['file_name']))
                        $file_name = $_POST['file_name'];
                if (empty($file_name))
                        $file_name = $_POST['qquuid'];
                $result = $uploader->handleUpload($base_dir . DS, $file_name);
                header("Content-Type: text/plain");
                $result['filepath'] = $base_dir . DS . $result['filename'];
                $result['fileurl'] = Yii::app()->baseUrl . '/public/temp/' . $_POST['qquuid'] . '/' . $result['filename'];
                echo json_encode($result);
        }

        /**
         *
         */
        public function actionDeleteFineUploader()
        {
                Common::deleteDir(APP_TEMP_DIR . DS . $_POST['qquuid']);
                echo CJSON::encode(array('success' => true));
        }

        public function actionUploadRedactor($dir = NULL, $baseurl = NULL)
        {
// files storage folder
                if (empty($dir))
                        $dir = Common::createDir(PUBLIC_DIR . DS . 'images' . DS . 'redactor');
                if (empty($baseurl))
                        $baseurl = Yii::app()->baseUrl . '/public/images/redactor';

                $response = Common::uploadImage($dir, 'file');
                if (isset($response['error'])) {
                        echo CJSON::encode(array('error' => $response['error']));
                        Yii::app()->end();
                }

                echo CJSON::encode(array('filelink' => $baseurl . '/' . $response['file_name']));
        }

}
