<?php

/**
 * Roles management controller
 * @author Fred <mconyango@gmail.com>
 */
class RolesController extends UsersModuleController {

        public function init()
        {
                $this->resourceLabel = 'Role';
                $this->resource = UserResources::RES_USER_ROLES;
                $this->activeMenu = self::MENU_USER_ROLES;

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
                        'actions' => array('index', 'create', 'view', 'update', 'delete'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        /**
         * Displays a particular model.
         * @param integer $id the ID of the model to be displayed
         */
        public function actionView($id)
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_VIEW);
                $model = UserRoles::model()->loadModel($id);
                $this->pageTitle = $model->name;
                $this->showPageTitle = TRUE;
                $this->pageDescription = $model->description;

                $forbidden_resources = Acl::getForbiddenResources(UserLevels::LEVEL_ADMIN);
                $resources = UserResources::model()->getResources($forbidden_resources);

                if (isset($_POST['RolesOnResources'])) {
                        $roles_on_resources = $_POST['RolesOnResources'];
                        foreach ($roles_on_resources as $key => $rr) {
                                UserRolesOnResources::model()->set($key, $id, $rr);
                        }
                        Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                        $this->refresh();
                }

                $this->render('view', array(
                    'model' => $model,
                    'resources' => $resources,
                ));
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);

                $model = new UserRoles;
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->redirect(array('view', 'id' => $model->id));
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

                $model = UserRoles::model()->loadModel($id);
                $this->pageTitle = Lang::t('Edit ' . $this->resourceLabel);
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

                UserRoles::model()->loadModel($id)->delete();

                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t($this->resourceLabel . 's');
                $this->showPageTitle = TRUE;

                $this->render('index', array(
                    'model' => UserRoles::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'name'),
                ));
        }

}
