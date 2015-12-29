<?php

/**
 * User Levels management controller
 * @author Fred <fred@btimillman.com>
 */
class UserLevelsController extends UsersModuleController {

        public function init()
        {
                $this->resourceLabel = 'User Level';
                $this->resource = UserResources::RES_USER_LEVELS;
                $this->activeMenu = self::MENU_USER_LEVELS;

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

                $this->pageTitle = 'Add ' . $this->resourceLabel;

                $model = new UserLevels;
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if (!empty($model->banned_resources))
                                $model->banned_resources = implode(',', $model->banned_resources);
                        if ($model->save())
                                $this->redirect(array('index'));
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

                $this->pageTitle = 'Edit ' . $this->resourceLabel;

                $model = UserLevels::model()->loadModel($id);
                if (!empty($model->banned_resources))
                        $model->banned_resources = explode(',', $model->banned_resources);
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if (!empty($_POST[$model_class_name]['banned_resources']))
                                $model->banned_resources = implode(',', $model->banned_resources);
                        else
                                $model->banned_resources = NULL;
                        if ($model->save())
                                $this->redirect(array('index'));
                }

                $this->render('update', array(
                    'model' => $model,
                ));
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $level the ID of the model to be deleted
         */
        public function actionDelete($level)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);

                UserLevels::model()->loadModel($level)->delete();

                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        /**
         * Lists all user levels
         */
        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->showPageTitle = TRUE;
                $this->pageTitle = Lang::t($this->resourceLabel . 's');

                $this->render('index', array(
                    'model' => UserLevels::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'rank')
                ));
        }

}
