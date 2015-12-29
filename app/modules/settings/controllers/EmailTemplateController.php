<?php

/**
 * Email Templates controller
 * @author Fred <mconyango@gmail.com>
 */
class EmailTemplateController extends SettingsModuleController {

        /**
         * Executed before every action
         */
        public function init()
        {
                $this->resource = UserResources::RES_SETTINGS_EMAIL;
                $this->activeMenu = self::MENU_SETTINGS_EMAIL;
                $this->resourceLabel = 'Email template';
                $this->pageTitle = $this->resourceLabel;
                $this->activeTab = 2;
                $this->showPageTitle = FALSE;

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
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
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

                $model = new SettingsEmailTemplate;
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


                $model = SettingsEmailTemplate::model()->loadModel($id);
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
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id)
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_DELETE);
                SettingsEmailTemplate::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        /**
         * Lists all.
         */
        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);

                $this->pageTitle = Lang::t('Manage ' . $this->resourceLabel);

                $this->render('index', array(
                    'model' => SettingsEmailTemplate::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'id'),
                ));
        }

}
