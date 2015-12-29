<?php

class DependentMembersController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
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
    public function actionView($id) {

        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => empty($model) ? new DependentMembers : $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);
        $address_model = PersonAddress::model()->find('`person_id`=:t1', array(':t1' => $id));
        if (NULL === $address_model) {
            $address_model = new PersonAddress();
            $address_model->person_id = $id;
        }

        $models = $this->modelsLoop();

        $models = $this->addNewModel($models, $this->modelSave($models));

        $this->render('application.modules.users.views.default.view', array(
            'user_model' => $user_model,
            'person_model' => $person_model,
            'address_model' => $address_model,
            'models' => $models,
            'jamaa' => Person::model()->findByPk($_REQUEST['id']),
            'child' => DependentMembers::model()->dependents($id, 5) || DependentMembers::model()->dependents($id, 10),
            'spouse' => DependentMembers::model()->dependents($id, 4) || DependentMembers::model()->dependents($id, 9),
            'prnts' => DependentMembers::model()->dependents($id, 1) || DependentMembers::model()->dependents($id, 6),
            'inlaws' => DependentMembers::model()->dependents($id, 2) || DependentMembers::model()->dependents($id, 7),
            'siblings' => DependentMembers::model()->dependents($id, 3) || DependentMembers::model()->dependents($id, 8),
            'action' => Users::ACTION_ADD_DEPENDENTS,
            'render' => 'application.modules.members.views.dependentMembers.create'
        ));
    }

    public function orderModels() {
        $models = $this->loadModels($_REQUEST['id'], $_REQUEST['rltn1'], $_REQUEST['rltn2']);

        foreach ($models as $model)
            $mamodel[$model->primaryKey] = $model;

        return isset($mamodel) ? $mamodel : array();
    }

    public function modelsLoop() {
        $models = $this->orderModels();

        if (isset($_POST['DependentMembers']))
            foreach ($_POST['DependentMembers'] as $w => $model) {
                if (!isset($models[$w]))
                    $models[$w] = $this->newModel();

                $models[$w]->attributes = $_POST['DependentMembers'][$w];
            }

        return $models;
    }

    public function loadModels($id, $rltnshp1, $rltnshp2) {
        $cri = new CDbCriteria;
        $cri->condition = 'principal_member=:id && (relationship=:rltn1 || relationship=:rltn2)';
        $cri->params = array(':id' => $id, ':rltn1' => $rltnshp1, ':rltn2' => $rltnshp2);
        $cri->order = 'name ASC';

        return DependentMembers::model()->findAll($cri);
    }

    public function modelSave($models) {
        $addNewModel = true;

        if (isset($_POST['DependentMembers']))
            foreach ($models as $i => $model)
                if (!$models[$i]->save())

                //if new model does not save, return false
                    $addNewModel = $models[$i]->isNewRecord ? false : $addNewModel;

        return $addNewModel;
    }

    public function addNewModel($models, $addNewModel) {
        if ($addNewModel == true) {
            $models = $this->orderModels();
            $models['new'] = $this->newModel();
        }

        return $models;
    }

    public function newModel() {
        $model = new DependentMembers;
        $model->principal_member = $_REQUEST['id'];

        return $model;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DependentMembers'])) {
            $model->attributes = $_POST['DependentMembers'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('DependentMembers');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new DependentMembers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DependentMembers']))
            $model->attributes = $_GET['DependentMembers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DependentMembers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DependentMembers::model()->findByPk($id);
//        if ($model === null)
//            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DependentMembers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dependent-members-form') {
            echo CActiveForm::validate($models[$i]);
            Yii::app()->end();
        }
    }

}
