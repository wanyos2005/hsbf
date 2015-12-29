<?php

/**
 * Units of measure and units conversions controller
 * @author Fred<mconyango@gmail.com>
 */
class UnitsController extends SettingsModuleController {

        public function init()
        {
                $this->resource = UserResources::RES_SETTINGS_UNITS_OF_MEASURE;
                $this->activeMenu = self::MENU_SETTINGS_UNITS_OF_MEASURE;
                $this->resourceLabel = 'Unit';

                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,deleteConversion', // we only allow deletion via POST request
                    'ajaxOnly + getToList',
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
                        'actions' => array('index', 'create', 'createConversion', 'update', 'updateConversion', 'delete', 'deleteConversion', 'getToList'),
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
        public function actionCreate($sel = null)
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);

                $model = new SettingsUnitsOfMeasure;
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
                        if (!empty($sel)) {
                                $data = CJSON::encode($model->getData('id,name'));
                                echo CJSON::encode(array('success' => true, 'select' => $sel, 'selected' => $model->id, 'optionData' => $data));
                        }
                        else
                                echo CJSON::encode(array('success' => true, 'message' => Lang::t('SUCCESS_MESSAGE'), 'redirectUrl' => $this->createUrl('index')));
                        Yii::app()->end();
                }

                $this->renderPartial('_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        public function actionCreateConversion()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel . ' Conversion');

                $model = new SettingsUnitsConversion;
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

                $this->renderPartial('conversion/_conversionColorboxForm', array('model' => $model), FALSE, TRUE);
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                $this->pageTitle = Lang::t('Edit ' . $this->resourceLabel);

                $model = SettingsUnitsOfMeasure::model()->loadModel($id);
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

                $this->renderPartial('conversion/_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        public function actionUpdateConversion($id)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                $this->pageTitle = Lang::t('Edit ' . $this->resourceLabel);

                $model = SettingsUnitsConversion::model()->loadModel($id);
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

                $this->renderPartial('conversion/_conversionColorboxForm', array('model' => $model), FALSE, TRUE);
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                SettingsUnitsOfMeasure::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionDeleteConversion($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                SettingsUnitsConversion::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        /**
         * Lists all models.
         */
        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t($this->resourceLabel . 's');

                $this->render('index', array(
                    'model' => SettingsUnitsOfMeasure::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'name asc'),
                    'conversionModel' => SettingsUnitsConversion::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'from_unit_id,to_unit_id'),
                ));
        }

        public function actionGetToList($from, $to = NULL)
        {
                echo CJSON::encode(SettingsUnitsConversion::model()->getToLists($from, $to));
        }

}
