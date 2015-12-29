<?php

class KinsAndNomineesController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = '//layouts/column2';

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
                'actions' => array('create', 'update', 'pasent'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
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

        $models = self::kinsOrNominees();

        //$this->performAjaxValidation($model);

        if (isset($_POST['KinsAndNominees']))
            foreach ($models as $m => $model) {
                $models[$m]->attributes = $_POST['KinsAndNominees'][$model->dependent_member];
                KinsAndNominees::model()->modelSave($models[$m]);
            }

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
            'action' => $_REQUEST['kiNom'] == 'kin' ? KinsAndNominees::NEXT_OF_KIN : KinsAndNominees::NOMINEE,
            'render' => 'application.views.kinsAndNominees.create'
        ));
    }

    /**
     * 
     * @return \KinsAndNominees Models to be created or updated.
     */
    public static function kinsOrNominees() {
        for ($rltnshp = 1; $rltnshp <= 5; $rltnshp++)
            $dependents[$rltnshp] = DependentMembers::model()->returnDependentsOfMember($_REQUEST['id'], $rltnshp, $rltnshp + 5);

        foreach (empty($dependents) ? array() : $dependents as $rltnshps)
            foreach ($rltnshps as $dependent) {
                $kinOrNominee[$dependent->primaryKey] = KinsAndNominees::model()->find('dependent_member=:mbr && kinOrNominee=:kin', array(':mbr' => $dependent->primaryKey, ':kin' => $_REQUEST['kiNom'] == 'kin' ? KinsAndNominees::NEXT_OF_KIN : KinsAndNominees::NOMINEE));

                if (empty($kinOrNominee[$dependent->primaryKey])) {
                    $kinOrNominee[$dependent->primaryKey] = new KinsAndNominees;
                    $kinOrNominee[$dependent->primaryKey]->dependent_member = $dependent->primaryKey;
                    $kinOrNominee[$dependent->primaryKey]->kinOrNominee = $_REQUEST['kiNom'] == 'kin' ? KinsAndNominees::NEXT_OF_KIN : KinsAndNominees::NOMINEE;
                    $kinOrNominee[$dependent->primaryKey]->active = KinsAndNominees::INACTIVE;
                }

                if ($dependent->alive != 1) {
                    if (!$kinOrNominee[$dependent->primaryKey]->isNewRecord && $kinOrNominee[$dependent->primaryKey]->active != KinsAndNominees::INACTIVE) {
                        $kinOrNominee[$dependent->primaryKey]->active = KinsAndNominees::INACTIVE;
                        $kinOrNominee[$dependent->primaryKey]->update(array('active'));
                    }
                    unset($kinOrNominee[$dependent->primaryKey]);
                }
            }

        return empty($kinOrNominee) ? array() : $kinOrNominee;
    }

    public static function percentagesUpto100() {
        $percent = 0;

        $models = self::kinsOrNominees();

        foreach ($models as $model)
            if (isset($_POST['KinsAndNominees'][$model->dependent_member]))
                if ($percent + $_POST['KinsAndNominees'][$model->dependent_member]['percent'] > 100)
                    return true;
                else
                    $percent = $percent + $_POST['KinsAndNominees'][$model->dependent_member]['percent'];
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

        if (isset($_POST['KinsAndNominees'])) {
            $model->attributes = $_POST['KinsAndNominees'];
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
        $dataProvider = new CActiveDataProvider('KinsAndNominees');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new KinsAndNominees('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['KinsAndNominees']))
            $model->attributes = $_GET['KinsAndNominees'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return KinsAndNominees the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = KinsAndNominees::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param KinsAndNominees $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'kins-and-nominees-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPasent($member, $kiNom) {
        if ($kiNom == 'nom')
            echo CHtml::activeTextField(new KinsAndNominees, "[$member]percent", array(
                'size' => 5, 'maxlength' => 5, 'numeric' => true, 'style' => 'text-align:center',
                'readonly' => $_POST['KinsAndNominees'][$member]['active'] == KinsAndNominees::ACTIVE ? false : true,
                'required' => $_POST['KinsAndNominees'][$member]['active'] == KinsAndNominees::ACTIVE ? true : false
                    )
            );
    }

}
