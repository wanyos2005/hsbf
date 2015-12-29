<?php

class DefaultController extends DeptModuleController {

        public function init()
        {
                $this->resource = UserResources::RES_DEPT;
                $this->activeMenu = self::MENU_DEPT;
                $this->resourceLabel = 'Department';
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete',
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
                        'actions' => array('index', 'view', 'create', 'update', 'delete'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        public function actionView($id)
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);

                $model = Dept::model()->loadModel($id);
                $this->pageTitle = $model->name;

                $this->render('view', array(
                    'model' => $model,
                ));
        }

        public function actionCreate()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);

                $model = new Dept();
                $model_class_name = $model->getClassName();
                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('Department saved successfully. Now create the contact person.'));
                                $this->redirect(Yii::app()->createUrl('users/default/create', array('dept_id' => $model->id, Controller::GET_PARAM_RETURN_URL => $this->createUrl('view', array('id' => $model->id)))));
                        }
                }

                $this->render('create', array(
                    'model' => $model,
                ));
        }

        public function actionUpdate($id)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                $this->pageTitle = Lang::t('Edit ' . $this->resourceLabel);

                $model = Dept::model()->loadModel($id);
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->redirect(Controller::getReturnUrl($this->createUrl('view', array('id' => $model->id))));
                        }
                }

                $this->render('update', array(
                    'model' => $model,
                ));
        }

        public function actionDelete($id)
        {
                $this->hasPrivilege(Acl::ACTION_DELETE);
                Dept::model()->loadModel($id)->delete();
                if (!Yii::app()->request->isAjaxRequest)
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t(Common::pluralize($this->resourceLabel));

                $searchModel = Dept::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'name');
                $this->render('index', array(
                    'model' => $searchModel,
                ));
        }

}
