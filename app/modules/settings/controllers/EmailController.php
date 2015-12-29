<?php

class EmailController extends SettingsModuleController {

        public function init()
        {
                $this->resource = UserResources::RES_SEND_EMAIL;
                $this->resourceLabel = 'Mass Email';
                $this->activeMenu = self::MENU_SETTINGS_EMAIL;

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
                        'actions' => array('index', 'view', 'create', 'delete'),
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
                //@todo
                $this->redirect(array('create'));
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
                $this->hasPrivilege(Acl::ACTION_CREATE);

                $this->pageTitle = 'Send' . ' ' . $this->resourceLabel;

                $model = new EmailQueue(EmailQueue::SCENARIO_MASS_EMAIL);
                $model->sent_by = Yii::app()->user->id;
                $model->from_name = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_COMPANY_NAME, 'xchnge');
                $model->from_email = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_ADMIN_EMAIL, 'support@xchnge.co');
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];

                        if ($model->validate()) {
                                Yii::app()->user->setFlash('success', Lang::t('Email successfully queued for sending.'));
                                $this->refresh();
                        }
                }

                $this->render('create', array(
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
                EmailQueue::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        public function actionIndex()
        {
                //@todo
                $this->redirect(array('create'));
        }

}
