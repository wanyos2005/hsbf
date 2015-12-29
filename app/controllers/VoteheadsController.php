<?php

class VoteheadsController extends Controller {
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
                'actions' => array('create', 'update', 'votehead', 'confirmDelete', 'deleteVotehead'),
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
     * create a vote head
     * 
     * @param string $type type of votehead
     */
    public function actionVotehead($type) {
        $form = $this->beginWidget(
                'CActiveForm', array(
            'id' => 'expenditures-form',
            'enableAjaxValidation' => true,
                )
        );

        $incomeOrExpense = $type == Voteheads::INCOME ? new Incomes : new Expenditures;
        $incomeOrExpense->votehead = $_POST[get_class($incomeOrExpense)]['votehead'];

        $fieldType = $_POST[$type];

        if ($fieldType == Voteheads::TEXT) {

            $voteHead = new Voteheads;

            $voteHead->votehead = $incomeOrExpense->votehead;
            $voteHead->incomeOrExpense = $type;

            if (!$voteHead->save())
                $incomeOrExpense->addError('votehead', 'Error: Votehead either already exists, is numeric, too long or too short or otherwise');
            else
                $fieldType = Voteheads::SELECT;
        } else
        if ($incomeOrExpense->votehead == Voteheads::NEW_VOTEHEAD) {
            $incomeOrExpense->votehead = null;
            $fieldType = Voteheads::TEXT;
        }

        $this->renderPartial('application.views.expenditures.voteHead', array(
            'field' => $type, 'model' => $incomeOrExpense, 'form' => $form, 'fieldType' => $fieldType
                )
        );
    }

    /**
     * confirm delete
     * 
     * @param int $id vote head id
     * @param string $field type of vote head
     */
    public function actionConfirmDelete($id, $field) {
        $this->renderPartial('application.views.expenditures.confirmDelete', array('id' => $id, 'field' => $field));
    }

    /**
     * delete a vote head and load the remaining vote heads
     * 
     * @param int $id vote head id
     * @param string $field type of vote head
     */
    public function actionDeleteVotehead($id, $field) {
        $votehead = Voteheads::model()->findByPk($id);

        if (!empty($votehead))
            if ($votehead->votehead != Expenditures::DEPOSIT_TO_BANK && $votehead->votehead != Incomes::WITHDRAWAL_FROM_BANK)
                $votehead->delete();

        $this->renderPartial('application.views.expenditures.deleteVoteheads', array('field' => $field));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Voteheads;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Voteheads'])) {
            $model->attributes = $_POST['Voteheads'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Voteheads'])) {
            $model->attributes = $_POST['Voteheads'];
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
        $dataProvider = new CActiveDataProvider('Voteheads');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Voteheads('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Voteheads']))
            $model->attributes = $_GET['Voteheads'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Voteheads the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Voteheads::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Voteheads $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'voteheads-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
