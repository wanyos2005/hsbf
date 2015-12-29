<?php

class ModulesController extends SettingsModuleController {

        public function init()
        {
                $this->resource = UserResources::RES_MODULES_ENABLED;
                $this->activeMenu = self::MENU_MODULES_ENABLED;
                $this->resourceLabel = 'Module';
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,updateStatus',
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
                        'actions' => array('index', 'create', 'update', 'delete', 'updateStatus'),
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
                $this->pageTitle = Lang::t(Constants::LABEL_CREATE . ' ' . $this->resourceLabel);

                $model = new ModulesEnabled;
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
                $this->pageTitle = Lang::t(Constants::LABEL_UPDATE . ' ' . $this->resourceLabel);

                $model = ModulesEnabled::model()->loadModel($id);
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
                ModulesEnabled::model()->loadModel($id)->delete();
                if (!Yii::app()->request->isAjaxRequest)
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t('Manage ' . $this->resourceLabel . 's');
                $searchModel = ModulesEnabled::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION], 'id');
                $this->render('index', array(
                    'model' => $searchModel,
                ));
        }

        public function actionUpdateStatus($id, $status)
        {
                $this->hasPrivilege(Acl::ACTION_UPDATE);
                if (!array_key_exists($status, ModulesEnabled::getStatuses()))
                        throw new CHttpException(403, Lang::t('403_error'));

                $model = ModulesEnabled::model()->loadModel($id);
                $model->status = $status;
                $model->save(FALSE);
        }

}
