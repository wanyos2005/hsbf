<?php

/**
 * Used to add page-specific keywords,descriptions and other meta tags
 * This is only applicable to searchable/indexed pages by search engines
 * @author Fred <mconyango@gmail.com>
 */
class PageController extends SettingsModuleController {

        public function init()
        {
                parent::init();
                $this->resourceLabel = 'Web Page';
                $this->resource = UserResources::RES_SETTINGS_PAGE;
                $this->activeMenu = self::MENU_SETTINGS_PAGE;
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
                $this->pageTitle = Lang::t('Add ' . $this->resourceLabel);

                $model = new SettingsPage();
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

                $model = SettingsPage::model()->loadModel($id);
                $model->setScenario(ActiveRecord::SCENARIO_UPDATE);
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
                SettingsPage::model()->loadModel($id)->delete();
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        /**
         * Lists all models.
         */
        public function actionIndex()
        {
                $this->hasPrivilege(Acl::ACTION_VIEW);

                $this->pageTitle = Lang::t($this->resourceLabel . 's');
                $this->showPageTitle = TRUE;

                $this->render('index', array(
                    'model' => SettingsPage::model()->searchModel(array(), $this->settings[Constants::KEY_PAGINATION]),
                ));
        }

}
