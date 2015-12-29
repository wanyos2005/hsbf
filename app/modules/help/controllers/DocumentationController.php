<?php

class DocumentationController extends AdminModuleController {

        public function init()
        {
                parent::init();
                $this->homeTitle = Lang::t('Documentation');
                $this->activeTab = 2;
                $this->resource = UserResources::RES_DOCUMENTATION;
                $this->activeMenu = self::MENU_HELP;
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,deleteHelpCategory', // we only allow deletion via POST request
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
                        'actions' => array('index', 'admin', 'create', 'update', 'delete', 'uploadRedactor', 'helpCategory', 'createHelpCategory', 'updateHelpCategory', 'deleteHelpCategory'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        public function actionIndex($cat_id = null)
        {
                $this->activeTab = 1;
                $this->pageTitle = $this->homeTitle;
                $condition = '';
                $params = array();
                if (!empty($cat_id)) {
                        $condition.='`category_id`=:t1';
                        $params[':t1'] = $cat_id;
                }
                $data = HelpTopic::model()->getData('*', $condition, $params, 'category_id asc,topic asc');
                $this->render('index', array(
                    'data' => $data,
                ));
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_CREATE);
                $this->pageTitle = 'Add ' . $this->homeTitle;
                $model = new HelpTopic(ActiveRecord::SCENARIO_CREATE);
                $class_name = $model->getClassName();

                if (isset($_POST[$class_name])) {
                        $model->attributes = $_POST[$class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->refresh();
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
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_UPDATE);
                $this->pageTitle = 'Update ' . $this->homeTitle;
                $model = HelpTopic::model()->loadModel($id);
                $model->setScenario(ActiveRecord::SCENARIO_UPDATE);
                $class_name = $model->getClassName();

                if (isset($_POST[$class_name])) {
                        $model->attributes = $_POST[$class_name];
                        if ($model->save()) {
                                Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                                $this->redirect(array('admin'));
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
                HelpTopic::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

        /**
         * Lists all models.
         */
        public function actionAdmin()
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_VIEW);
                $this->pageTitle = 'Manage ' . $this->homeTitle;
                $this->render('admin', array(
                    'model' => HelpTopic::model()->searchModel(),
                ));
        }

        public function actionUploadRedactor()
        {
                // files storage folder
                $dir = Common::createDir(PUBLIC_DIR . DS . 'docs' . DS . 'images');
                $response = Common::uploadImage($dir, 'file');
                if (isset($response['error'])) {
                        echo CJSON::encode(array('error' => $response['error']));
                        Yii::app()->end();
                }

                echo CJSON::encode(array('filelink' => Yii::app()->baseUrl . '/public/docs/images/' . $response['file_name']));
        }

        public function actionHelpCategory()
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_VIEW);
                $this->activeTab = 3;
                $this->pageTitle = 'Manage Help Category';
                $this->render('helpCategory/index', array(
                    'model' => HelpCategory::model()->searchModel(),
                ));
        }

        public function actionCreateHelpCategory()
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_CREATE);
                $this->pageTitle = 'Add Help Category';
                $model = new HelpCategory(ActiveRecord::SCENARIO_CREATE);
                $modelClassName = $model->getClassName();

                if (isset($_POST[$modelClassName])) {
                        $model->attributes = $_POST[$modelClassName];
                        if ($model->save()) {
                                $success_message = Lang::t('SUCCESS_MESSAGE');
                                $redirectUrl = $this->createUrl('helpCategory');
                                if (Yii::app()->request->isAjaxRequest) {
                                        echo CJSON::encode(array('message' => $success_message, 'success' => true, 'hideForm' => true, 'redirectUrl' => $redirectUrl));
                                        Yii::app()->end();
                                } else {
                                        Yii::app()->user->setFlash('success', $success_message);
                                        $this->redirect($redirectUrl);
                                }
                        } else {
                                if (Yii::app()->request->isAjaxRequest) {
                                        echo CJSON::encode(array('message' => CActiveForm::validate($model), 'success' => false));
                                        Yii::app()->end();
                                }
                        }
                }
                if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('helpCategory/_colorboxForm', array(
                            'model' => $model,
                                ), FALSE, TRUE);
                } else {
                        $this->render('helpCategory/create', array(
                            'model' => $model,
                        ));
                }
        }

        public function actionUpdateHelpCategory($id)
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_UPDATE);
                $this->pageTitle = 'Update Help Category';
                $model = HelpCategory::model()->loadModel($id);
                $model->setScenario(ActiveRecord::SCENARIO_UPDATE);
                $modelClassName = $model->getClassName();

                if (isset($_POST[$modelClassName])) {
                        $model->attributes = $_POST[$modelClassName];
                        if ($model->save()) {
                                $success_message = Lang::t('SUCCESS_MESSAGE');
                                $redirectUrl = $this->createUrl('helpCategory');
                                if (Yii::app()->request->isAjaxRequest) {
                                        echo CJSON::encode(array('message' => $success_message, 'success' => true, 'hideForm' => true, 'redirectUrl' => $redirectUrl));
                                        Yii::app()->end();
                                } else {
                                        Yii::app()->user->setFlash('success', $success_message);
                                        $this->redirect($redirectUrl);
                                }
                        } else {
                                if (Yii::app()->request->isAjaxRequest) {
                                        echo CJSON::encode(array('message' => CActiveForm::validate($model), 'success' => false));
                                        Yii::app()->end();
                                }
                        }
                }
                if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('helpCategory/_colorboxForm', array(
                            'model' => $model,
                                ), FALSE, TRUE);
                } else {
                        $this->render('helpCategory/update', array(
                            'model' => $model,
                        ));
                }
        }

        public function actionDeleteHelpCategory($id)
        {
                Acl::hasPrivilege($this->privileges, $this->resource, Acl::ACTION_DELETE);
                HelpCategory::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('helpCategory'));
        }

}

