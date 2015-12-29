<?php

/**
 * Manage system resources: This controller should only be accessed by system engineer/author
 * @author Fred <mconyango@gmail.com>
 */
class ResourcesController extends UsersModuleController {

        public function init()
        {
                $this->resourceLabel = 'Resource';
                $this->resource = UserResources::RES_USER_RESOURCES;
                $this->activeMenu = self::MENU_USER_RESOURCES;

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
                        'actions' => array('create', 'update', 'index', 'delete'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        /**
         * Creates a new resource
         */
        public function actionCreate()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);

                $model = new UserResources;
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->redirect(array('index'));
                        }
                }

                $this->render('create', array(
                    'model' => $model,
                ));
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

                $model = UserResources::model()->loadModel($id);
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->redirect(array('index'));
                        }
                }

                $this->render('update', array(
                    'model' => $model,
                ));
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param string $id the ID of the model to be deleted
         */
        public function actionDelete($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);

                UserResources::model()->loadModel($id)->delete();

                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t($this->resourceLabel . 's');
                $this->showPageTitle = TRUE;

                $this->render('index', array(
                    'model' => UserResources::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'id')
                ));
        }

}
