<?php

/**
 * Tax settings controller
 * @author Fred <mconyango@gmail.com>
 */
class TaxController extends SettingsModuleController {

        public function init()
        {
                $this->resource = UserResources::RES_SETTINGS_TAXES;
                $this->activeMenu = self::MENU_SETTINGS_TAXES;
                $this->resourceLabel = 'Tax';
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,deleteCategory',
                    'ajaxOnly + create,update,createCategory,updateCategory',
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
                        'actions' => array('index', 'create', 'update', 'delete', 'createCategory', 'updateCategory', 'deleteCategory'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        public function actionCreate($cat_id = NULL)
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel);

                $model = new SettingsTaxes();
                $model->category_id = $cat_id;
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

        public function actionUpdate($id)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                $this->pageTitle = Lang::t(Constants::LABEL_UPDATE . Constants::SPACE . $this->resourceLabel);

                $model = SettingsTaxes::model()->loadModel($id);
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

        public function actionDelete($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                SettingsTaxes::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege();
                $this->pageTitle = Lang::t($this->resourceLabel . ' settings');

                $categories = SettingsTaxCategory::model()->getData('*', NULL, array(), 'id');

                $this->render('index', array(
                    'categories' => $categories,
                ));
        }

        public function actionCreateCategory()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel . Constants::SPACE . 'Category');

                $model = new SettingsTaxCategory;
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

                $this->renderPartial('category/_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        public function actionUpdateCategory($id)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                $this->pageTitle = Lang::t(Constants::LABEL_UPDATE . Constants::SPACE . $this->resourceLabel . Constants::SPACE . 'Category');

                $model = SettingsTaxCategory::model()->loadModel($id);
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

                $this->renderPartial('category/_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        public function actionDeleteCategory($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                SettingsTaxCategory::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

}
