<?php

class MemberWithdrawalController extends Controller {
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
                'actions' => array('create', 'update', 'renderPartialForm', 'memberWithdrawals', 'save'),
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
        $array = $this->initialize();
        $user_model = $array['user_model'];
        $person_model = $array['person_model'];
        $model = $array['model'];
        $readOnly = $array['readOnly'];

        $this->performAjaxValidation($model);

        $this->render('application.modules.users.views.default.default', array(
            'model' => $model,
            'others' => array('readOnly' => $readOnly),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Membership Withdrawals',
            'render' => 'application.views.memberWithdrawal.create'
                )
        );
    }

    /**
     * Save model and renderpartial a required form
     */
    public function actionRenderPartialForm() {
        $array = $this->initialize();
        $model = $array['model'];
        $readOnly = $array['readOnly'];

        $this->performAjaxValidation($model);

        if ($readOnly == false)
            if (isset($_POST['MemberWithdrawal'])) {
                $model->attributes = $_POST['MemberWithdrawal'];
                $save = $model->isNewrecord && $model->status == 'Yes' ? false : true;

                if ($save == true)
                    if ($model->save()) {
                        Users::model()->userStatus($model);
                        if ($model->status == 'Yes')
                            Yii::app()->user->setFlash('saved', 'You have chosen to retain your membership');
                        else
                            Yii::app()->user->setFlash('saved', 'Your request has been forwarded');
                    } else
                        Yii::app()->user->setFlash('saved', 'Your alteration was not captured');
            }

        $this->renderPartial('membership', array(
            'model' => $model,
            'others' => array('readOnly' => $readOnly),
            'user' => $array['user_model']
                )
        );
    }

    /**
     * Initialize model properties
     * 
     * @return type
     */
    public function initialize() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $model = $this->newOrPrevious($id);
        $readOnly = $this->applicationReadOnly($model);

        if ($readOnly == false)
            $this->performAjaxValidation($model);

        return array(
            'user_model' => $user_model,
            'person_model' => $person_model,
            'model' => $model,
            'readOnly' => $readOnly
        );
    }

    /**
     * Member has a row in withdrawal table?
     * If yes, return that model else return new model
     * 
     * @param type $member
     * @return \MemberWithdrawal
     */
    public function newOrPrevious($member) {
        $model = MemberWithdrawal::model()->member($member);

        if (empty($model)) {
            $model = new MemberWithdrawal;
            $model->member = $member;
            $model->status = 'Pending';
        }

        return $model;
    }

    /**
     * Establish whether model is to be read only or not
     * 
     * @param type $model
     * @return type
     */
    public function applicationReadOnly($model) {
        return $model->isNewrecord || $model->status == 'Yes' || ($model->status == 'Pending' && $model->forwarded_by_secretary == 'Pending' && $model->forwarded_by_treasurer == 'Pending' && $model->approved_by_chairman == 'Pending') ? false : true;
    }

    /**
     * Establish applications requiring authority of current user
     */
    public function actionMemberWithdrawals() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $loanApplications = $this->applications();

        if (!empty($_REQUEST['id']))
            $model = MemberWithdrawal::model()->findByPk($_REQUEST['id']);

        $this->render('application.modules.users.views.default.default', array(
            'model' => $loanApplications,
            'others' => array('model' => empty($model) ? new MemberWithdrawal : $model, 'authority' => Maofficio::model()->officio()),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Membership Withdrawals',
            'render' => 'application.views.memberWithdrawal.applications'
                )
        );
    }

    /**
     * Search respective loan applications according to user authority
     * 
     * @return type
     */
    public function applications() {
        $id = Yii::app()->user->id;

        $cri = new CDbCriteria;

        $currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
        if (!empty($currentChairman) && $currentChairman->member == $id) {
            $cri->condition = "status='Pending' && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && forwarded_by_treasurer!='Pending' && treasurer_date IS NOT NULL";
        } else {
            $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
            if (!empty($currentSecretary) && $currentSecretary->member == $id)
                $cri->condition = "status='Pending' && forwarded_by_treasurer='Pending' && treasurer_date IS NULL && approved_by_chairman='Pending' && chairman_date IS NULL";
            else {
                $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
                if (!empty($currentTreasurer) && $currentTreasurer->member == $id)
                    $cri->condition = "status='Pending' && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && approved_by_chairman='Pending' && chairman_date IS NULL";
            }
        }

        $cri->order = 'secretary_date DESC, treasurer_date DESC, chairman_date DESC, id ASC';

        return MemberWithdrawal::model()->findAll($cri);
    }

    /**
     * Save alterations
     */
    public function actionSave() {
        $model = MemberWithdrawal::model()->findByPk($_POST['MemberWithdrawal']['id']);

        $render = $this->authority($model);

        if ($render == true) {
            $this->renderPartial('applications', array(
                'model' => $this->applications(),
                'others' => array('model' => $model, 'authority' => $_POST['authority']),
                'user' => Users::model()->loadModel(Yii::app()->user->id),
                    )
            );
        }
    }

    /**
     * Return which authority making the changes
     * 
     * @param type $model
     * @return type
     */
    public function authority($model) {
        if ($_POST['authority'] == 'secretary')
            $render = $this->saveSecretary($model, $_POST['authority']);
        else
        if ($_POST['authority'] == 'treasurer')
            $render = $this->saveTreasurer($model, $_POST['authority']);
        else
        if ($_POST['authority'] == 'chairman')
            $render = $this->saveChairman($model, $_POST['authority']);

        return $render;
    }

    /**
     * Save forwarding by secretary and date
     * 
     * @param type $model
     * @param type $authority
     * @return type
     */
    public function saveSecretary($model, $authority) {
        $save = false;

        if ($model->forwarded_by_secretary != $_POST['MemberWithdrawal']['forwarded_by_secretary']) {
            $model->forwarded_by_secretary = $_POST['MemberWithdrawal']['forwarded_by_secretary'];

            if ($model->forwarded_by_secretary == 'Pending')
                $model->secretary_date = null;
            else
                $model->secretary_date = date('Y') . '-' . date('m') . '-' . date('d');

            $save = $this->setFlash($model, $authority);
        }

        return $save;
    }

    /**
     * Save forwarding by treasurer and date
     * 
     * @param type $model
     * @param type $authority
     * @return type
     */
    public function saveTreasurer($model, $authority) {
        $save = false;

        if ($model->forwarded_by_treasurer != $_POST['MemberWithdrawal']['forwarded_by_treasurer']) {
            $model->forwarded_by_treasurer = $_POST['MemberWithdrawal']['forwarded_by_treasurer'];

            if ($model->forwarded_by_treasurer == 'Pending')
                $model->treasurer_date = null;
            else
                $model->treasurer_date = date('Y') . '-' . date('m') . '-' . date('d');

            $save = $this->setFlash($model, $authority);
        }

        return $save;
    }

    /**
     * Save chairman approval and date,
     * and closure of loan application
     * 
     * @param type $model
     * @param type $authority
     * @return type
     */
    public function saveChairman($model, $authority) {
        $save = false;

        if ($model->approved_by_chairman != $_POST['MemberWithdrawal']['approved_by_chairman']) {
            $model->approved_by_chairman = $_POST['MemberWithdrawal']['approved_by_chairman'];

            if ($model->approved_by_chairman == 'Pending')
                $model->chairman_date = null;
            else
                $model->chairman_date = date('Y') . '-' . date('m') . '-' . date('d');

            if ($model->approved_by_chairman == 'Yes')
                $model->status = 'No';
            else
                $model->status = 'Pending';

            $save = $this->setFlash($model, $authority);
        }

        return $save;
    }

    /**
     * Return a message on successful model save or otherwise
     * 
     * @param type $model
     * @param type $authority
     * @return boolean
     */
    public function setFlash($model, $authority) {
        if ($model->save()) {
            if ($authority != 'chairman')
                if (($authority == 'secretary' && $model->forwarded_by_secretary == 'Yes') || ($authority == 'treasurer' && $model->forwarded_by_treasurer == 'Yes'))
                    Yii::app()->user->setFlash('saved', 'The withdrawal has been forwarded');
                else
                if (($authority == 'secretary' && $model->forwarded_by_secretary == 'No') || ($authority == 'treasurer' && $model->forwarded_by_treasurer == 'No'))
                    Yii::app()->user->setFlash('saved', 'The withdrawal has been declined');
                else
                    Yii::app()->user->setFlash('saved', 'The withdrawal has been withdrawn');
            else
            if ($model->approved_by_chairman == 'Yes')
                Yii::app()->user->setFlash('saved', 'The withdrawal has been approved');
            else
            if ($model->approved_by_chairman == 'No')
                Yii::app()->user->setFlash('saved', 'The withdrawal has been declined');
            else
                Yii::app()->user->setFlash('saved', 'The withdrawal has been withdrawn');

            $this->userStatus($model);

            return true;
        } else
            Yii::app()->user->setFlash('saved', 'The alteration has not been captured');

        return false;
    }

    /**
     * 
     * @param \MemberWithdrawal $model Model.
     */
    public function userStatus($model) {
        if ($_POST['authority'] == 'chairman' || ($model->member == Yii::app()->user->id && $model->forwarded_by_secretary == 'Pending' && $model->forwarded_by_treasurer == 'Pending' && $model->approved_by_chairman == 'Pending' && empty($model->secretary_date) && empty($model->treasurer_date) && empty($model->chairman_date)))
            Users::model()->userStatus($model);
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

        if (isset($_POST['MemberWithdrawal'])) {
            $model->attributes = $_POST['MemberWithdrawal'];
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
        $dataProvider = new CActiveDataProvider('MemberWithdrawal');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MemberWithdrawal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MemberWithdrawal']))
            $model->attributes = $_GET['MemberWithdrawal'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MemberWithdrawal the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MemberWithdrawal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MemberWithdrawal $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'member-withdrawal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
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
            case 'secretary': $attribute = array('authority' => 'forwarded_by_secretary', 'date' => 'secretary_date');
                break;
            case 'treasurer': $attribute = array('authority' => 'forwarded_by_treasurer', 'date' => 'treasurer_date');
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
                if ($application->forwarded_by_treasurer != 'Pending' || !empty($application->treasurer_date) || $application->approved_by_chairman != 'Pending' || !empty($application->chairman_date))
                    return true;
                break;
            case 'treasurer':
                if ($application->forwarded_by_secretary != 'Yes' || empty($application->secretary_date) || $application->approved_by_chairman != 'Pending' || !empty($application->chairman_date))
                    return true;
                break;
            case 'chairman':
                if ($application->forwarded_by_secretary != 'Yes' || empty($application->secretary_date) || $application->forwarded_by_treasurer != 'Yes' || empty($application->treasurer_date))
                    return true;
                break;

            default:
                break;
        }
    }

}
