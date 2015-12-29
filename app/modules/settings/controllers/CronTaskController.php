<?php

class CronTaskController extends SettingsModuleController {

        public function init()
        {
                $this->resourceLabel = 'Cron Task';
                $this->resource = UserResources::RES_SETTINGS_CRON;
                $this->activeMenu = self::MENU_SETTINGS_CRON;
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,start,stop', // we only allow deletion via POST request
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
                        'actions' => array('index', 'create', 'update', 'delete', 'start', 'stop'),
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
                $this->pageTitle = Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel);
                $model = new ConsoleTasks;
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
                $this->pageTitle = Lang::t(Constants::LABEL_UPDATE . Constants::SPACE . $this->resourceLabel);
                $model = ConsoleTasks::model()->loadModel($id);
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
                $this->hasPrivilege(Acl::ACTION_DELETE);
                ConsoleTasks::model()->loadModel($id)->delete();

                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege();
                $this->pageTitle = Lang::t($this->resourceLabel . 's');

                $searchModel = ConsoleTasks::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION]);
                $this->render('index', array(
                    'model' => $searchModel,
                ));
        }

        public function actionStart($id)
        {
                ConsoleTasks::model()->startTask($id);
        }

        public function actionStop($id)
        {
                ConsoleTasks::model()->stopTask($id);
        }

}
