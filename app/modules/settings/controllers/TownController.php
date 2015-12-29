<?php

/**
 * Towns management controller
 * @author Fred <mconyango@gmail.com>
 */
class TownController extends SettingsModuleController {

        public function init()
        {
                $this->resourceLabel = 'Town';
                $this->resource = UserResources::RES_SETTINGS_TOWN;
                $this->activeMenu = self::MENU_SETTINGS_TOWN;
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete', // we only allow deletion via POST request
                );
        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
                return array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);

                $model = new SettingsTown;
                $modelClassName = $model->getClassName();

                if (isset($_POST[$modelClassName])) {
                        $model->attributes = $_POST[$modelClassName];
                        $error_message = CActiveForm::validate($model);
                        $error_message_decoded = CJSON::decode($error_message);

                        if (!empty($error_message_decoded)) {
                                echo CJSON::encode(array('success' => false, 'message' => $error_message));
                                Yii::app()->end();
                        }

                        $model->save(FALSE);
                        echo CJSON::encode(array('success' => true, 'message' => Lang::t('SUCCESS_MESSAGE'), 'redirectUrl' => $this->createUrl('index')));
                        Yii::app()->end();
                }

                $this->renderPartial('_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id)
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Edit ' . $this->resourceLabel);

                $model = SettingsTown::model()->loadModel($id);
                $modelClassName = $model->getClassName();

                if (isset($_POST[$modelClassName])) {
                        $model->attributes = $_POST[$modelClassName];
                        $error_message = CActiveForm::validate($model);
                        $error_message_decoded = CJSON::decode($error_message);

                        if (!empty($error_message_decoded)) {
                                echo CJSON::encode(array('success' => false, 'message' => $error_message));
                                Yii::app()->end();
                        }

                        $model->save(FALSE);
                        echo CJSON::encode(array('success' => true, 'message' => Lang::t('SUCCESS_MESSAGE'), 'redirectUrl' => $this->createUrl('index')));
                        Yii::app()->end();
                }

                $this->renderPartial('_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                SettingsTown::model()->loadModel($id)->delete();

                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);

                $this->pageTitle = Lang::t($this->resourceLabel . 's');
                $this->showPageTitle = TRUE;

                $this->render('index', array(
                    'model' => SettingsTown::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'country_id,name'),
                ));
        }

}
