<?php

class CashWithdrawalsController extends Controller {
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
                'actions' => array('create', 'update', 'approveWithdrawals', 'secDate', 'chairDate', 'pesaDate', 'printWithdrawal'),
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
        $model = $this->newOrExistingModel($id);

        $this->performAjaxValidation($model);

        $this->posts($model);

        $this->render('application.modules.users.views.default.default', array(
            'model' => $model,
            'others' => array(),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Cash Withdrawals',
            'render' => 'application.views.cashWithdrawals.create'
        ));
    }

    /**
     * 
     * @param \CashWithdrawals $model Model
     */
    public function posts($model) {
        if (isset($_POST['CashWithdrawals'])) {
            $model->attributes = $_POST['CashWithdrawals'];
            CashWithdrawals::model()->dateThis($model);
            $this->approvals($model);

            if ($model->save()) {

                if ($model->effected_by_treasurer == CashWithdrawals::YES && !empty($model->treasurer_date) && $model->approved_by_chairman == CashWithdrawals::YES && !empty($model->chairman_date) && $model->received_by_secretary == CashWithdrawals::YES && !empty($model->secretary_date)) {
                    Expenditures::model()->cashWithdrawalIsExpense($model);
                    Savings::model()->cashWithdrawaltoSavings($model);
                }

                Yii::app()->user->setFlash('saved', 'The alteration has been succcessfully saved');
            }
        }
    }

    /**
     * 
     * @param \CashWithdrawals $model Approvals and respective dates
     */
    public function approvals($model) {
        if (!$model->validate(array('cash_or_cheque', 'amount', 'date'))) {
            $model->received_by_secretary = CashWithdrawals::PENDING;
            $model->approved_by_chairman = CashWithdrawals::PENDING;
            $model->effected_by_treasurer = CashWithdrawals::PENDING;
        }

        $model->secretary_date = $model->received_by_secretary == CashWithdrawals::PENDING ? null : $model->secretary_date;
        $model->chairman_date = $model->approved_by_chairman == CashWithdrawals::PENDING ? null : $model->chairman_date;
        $model->treasurer_date = $model->effected_by_treasurer == CashWithdrawals::PENDING ? null : $model->treasurer_date;
    }

    /**
     * 
     * @param int $member
     * @return \CashWithdrawals If member has a pending application then update that, else apply newly.
     */
    public function newOrExistingModel($member) {
        $model = CashWithdrawals::model()->find("member=:mbr && (received_by_secretary = 'Pending' || approved_by_chairman = 'Pending' || effected_by_treasurer = 'Pending'"
                . "|| secretary_date IS NULL || chairman_date IS NULL || treasurer_date IS NULL)", array(':mbr' => $member));

        if (!empty($model))
            return $model;

        $model = new CashWithdrawals;
        $model->member = $member;

        return $model;
    }

    public function actionApproveWithdrawals() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        if (!empty($_REQUEST['id'])) {
            $model = CashWithdrawals::model()->returnAWithdrawal($_REQUEST['id']);
            $this->posts($model);
        }

        $withdrawals = $this->applications();

        $this->render('application.modules.users.views.default.default', array(
            'model' => $withdrawals,
            'others' => array('model' => empty($model) ? new CashWithdrawals : $model, 'authority' => Maofficio::model()->officio()),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Savings Withdrawals',
            'render' => 'application.views.cashWithdrawals.applications'
                )
        );
    }

    /**
     * Search respective withdrawals according to user authority
     * 
     * @return \CashWithdrawals
     */
    public function applications() {
        $id = Yii::app()->user->id;

        $cri = new CDbCriteria;

        $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
        if (!empty($currentTreasurer) && $currentTreasurer->member == $id) {
            $cri->condition = "effected_by_treasurer!='Yes' && received_by_secretary='Yes' && secretary_date IS NOT NULL && approved_by_chairman='Yes' && chairman_date IS NOT NULL";
        } else {
            $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
            if (!empty($currentSecretary) && $currentSecretary->member == $id)
                $cri->condition = "approved_by_chairman='Pending' && chairman_date IS NULL && effected_by_treasurer='Pending' && treasurer_date IS NULL";
            else {
                $currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
                if (!empty($currentChairman) && $currentChairman->member == $id)
                    $cri->condition = "received_by_secretary='Yes' && secretary_date IS NOT NULL && effected_by_treasurer='Pending' && treasurer_date IS NULL";
            }
        }

        $cri->order = 'treasurer_date DESC, chairman_date DESC, secretary_date DESC, id ASC';

        return CashWithdrawals::model()->findAll($cri);
    }

    /**
     * print cash withdrawal
     * 
     * @param int $id cash withdrawal id
     */
    public function actionPrintWithdrawal($id) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Savings Withdrawal', 'application.views.pdf.cashWithdrawal', array('withdrawal' => CashWithdrawals::model()->findByPk($id)), 'Savings Withdrawal'
        );
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

        if (isset($_POST['CashWithdrawals'])) {
            $model->attributes = $_POST['CashWithdrawals'];
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
        $dataProvider = new CActiveDataProvider('CashWithdrawals');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CashWithdrawals('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CashWithdrawals']))
            $model->attributes = $_GET['CashWithdrawals'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CashWithdrawals the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CashWithdrawals::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CashWithdrawals $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cash-withdrawals-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * update secretary_date
     */
    public function actionSecDate() {
        if ($_POST['CashWithdrawals']['received_by_secretary'] != CashWithdrawals::PENDING) {
            if ($_POST['CashWithdrawals']['received_by_secretary'] == $_POST['received_by_secretary'])
                $date = $_POST['secretary_date'];
            else
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            if (empty($date))
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            echo CHtml::activeTextField(new CashWithdrawals, 'secretary_date', array('value' => $date, 'readonly' => true, 'style' => 'text-align:center'));
        }
    }

    /**
     * update chairman_date
     */
    public function actionChairDate() {
        if ($_POST['CashWithdrawals']['approved_by_chairman'] != CashWithdrawals::PENDING) {
            if ($_POST['CashWithdrawals']['approved_by_chairman'] == $_POST['approved_by_chairman'])
                $date = $_POST['chairman_date'];
            else
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            if (empty($date))
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            echo CHtml::activeTextField(new CashWithdrawals, 'chairman_date', array('value' => $date, 'readonly' => true, 'style' => 'text-align:center'));
        }
    }

    /**
     * update treasurer_date
     */
    public function actionPesaDate() {
        if ($_POST['CashWithdrawals']['effected_by_treasurer'] != CashWithdrawals::PENDING) {
            if ($_POST['CashWithdrawals']['effected_by_treasurer'] == $_POST['effected_by_treasurer'])
                $date = $_POST['treasurer_date'];
            else
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            if (empty($date))
                $date = date('Y') . '-' . date('m') . '-' . date('d');

            echo CHtml::activeTextField(new CashWithdrawals, 'treasurer_date', array('value' => $date, 'readonly' => true, 'style' => 'text-align:center'));
        }
    }

    /**
     * Determine what approvals a given authority can alter
     * 
     * @param type $authority
     * @return string
     */
    public function returnAttributes($authority, $model) {
        switch ($authority) {
            case 'secretary': $attribute = array('authority' => 'received_by_secretary', 'date' => 'secretary_date');
                break;
            case 'treasurer': $attribute = array('authority' => 'effected_by_treasurer', 'date' => 'treasurer_date');
                break;
            case 'chairman': $attribute = array('authority' => 'approved_by_chairman', 'date' => 'chairman_date');
                break;

            default:
                break;
        }
        $attribute['readOnly'] = $this->readOnly($authority, $model);

        return $attribute;
    }

    /**
     * The authority will modify attributes or not
     * 
     * @param type $authority
     * @param type $application
     * @return boolean
     */
    public function readOnly($authority, $application) {
        switch ($authority) {
            case 'secretary':
                if ($application->effected_by_treasurer != 'Pending' || !empty($application->treasurer_date) || $application->approved_by_chairman != 'Pending' || !empty($application->chairman_date))
                    return true;
                break;
            case 'treasurer':
                if ($application->effected_by_treasurer != 'Pending' || !empty($application->treasurer_date))
                    return true;
                break;
            case 'chairman':
                if ($application->received_by_secretary != 'Yes' || empty($application->secretary_date) || $application->effected_by_treasurer != 'Pending' || !empty($application->treasurer_date))
                    return true;
                break;

            default:
                break;
        }
    }

}
