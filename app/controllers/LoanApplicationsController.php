<?php

class LoanApplicationsController extends Controller {
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
                'actions' => array('create', 'update', 'guarantor', 'guarantor1', 'renderPartialForm', 'loansMemberIsServicing',
                    'loanApplications', 'myPendingLoanApplications', 'save', 'printLoan', 'allMembersLoans'),
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
        $folder = Yii::getPathOfAlias('webroot') . '/payslips/';
        $array = $this->initialize();
        $user_model = $array['user_model'];
        $person_model = $array['person_model'];

        $this->saveLoan($model = $array['model'], $readOnly = $array['readOnly']);

        $this->render('application.modules.users.views.default.default', array(
            'model' => $model,
            'others' => array('readOnly' => $readOnly),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Loan Facility',
            'render' => 'application.views.loanApplications.create'
                )
        );
    }

    /**
     * 
     * @param int $id person id
     */
    public function actionMyPendingLoanApplications() {
        $model = $this->loniSi(
                $id = empty($_REQUEST['id']) ?
                Yii::app()->user->id :
                $_REQUEST['id'], //
                $loans = LoanApplications::model()->loansBeingApplied($id, true)
        );

        if (is_object($model)) {
            $this->assignThePost($model, $readOnly = $this->applicationReadOnly($model));
            $this->saveLoan($model, $readOnly);
        }

        $this->render('application.modules.users.views.default.default', array(
            'model' => $model,
            'others' => array('loans' => $loans, 'readOnly' => $readOnly, 'source' => true),
            'user_model' => Users::model()->loadModel($id),
            'person_model' => Person::model()->findByPk($id),
            'title' => 'Loan Facility',
            'render' => 'application.views.loanApplications.pendingApplications'
                )
        );
    }

    /**
     *
     * @param \LoanApplications $model model
     * @param boolean $readOnly false - save
     */
    public function saveLoan($model, $readOnly) {
        if ($readOnly == false)
            if (isset($_POST['LoanApplications']))
                if ($model->save()) {
                    Yii::app()->user->setFlash('saved', 'Your application has been succcessfully saved');
                    $this->refresh();
                }
    }

    /**
     * 
     * @param int $member member id
     * @param \LoanApplications $loans models
     * @return \LoanApplications model
     */
    public function loniSi($member, $loans) {
        $model = isset($_REQUEST['loniSi']) ?
                (
                $_REQUEST['loniSi'] == 'new' ? new LoanApplications :
                        LoanApplications::model()->findByPk($_REQUEST['loniSi'])
                ) :
                (
                empty($loans) ? null : $loans[0]
                );

        if (is_object($model) && empty($model->member))
            $model->member = $member;

        return $model;
    }

    public function initialize() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $model = $this->newOrPrevious($id);
        $readOnly = $this->applicationReadOnly($model);

        $this->assignThePost($model, $readOnly);

        return array(
            'user_model' => $user_model,
            'person_model' => $person_model,
            'model' => $model,
            'readOnly' => $readOnly
        );
    }

    /**
     * 
     * @param int $lonisi loan id
     * @param int $member person id
     * @return array form variables
     */
    public function pseudoInitialize($lonisi, $member) {
        $this->assignThePost(
                $model = $lonisi == 'new' ? new LoanApplications :
                LoanApplications::model()->findByPk($lonisi), $readOnly = $this->applicationReadOnly($model)
        );

        if (empty($model->member))
            $model->member = $member;

        return array(
            'model' => $model,
            'readOnly' => $readOnly
        );
    }

    /**
     * 
     * @param \LoanApplications $model model
     * @param boolean $readOnly false - assign variable from form - post
     */
    public function assignThePost($model, $readOnly) {
        if ($readOnly == false) {
            $this->performAjaxValidation($model);

            if (isset($_POST['LoanApplications'])) {
                $model->attributes = $_POST['LoanApplications'];
                Images::model()->picha($model, 'payslip', Yii::app()->basePath . "/payslips/");
                $this->witnessNguarantorDates($model);
            }
        }
    }

    public function newOrPrevious($member) {
        $model = LoanApplications::model()->find("member=:mbr && (forwarded_by_secretary='Pending' || (forwarded_by_secretary='Yes' && forwarded_by_treasurer='Pending') || (forwarded_by_secretary='Yes' && forwarded_by_treasurer='Yes' && approved_by_chairman='Pending')) && closed !='Yes'", array(':mbr' => $member));

        if (empty($model)) {
            $model = new LoanApplications;
            $model->member = $member;
            $model->serviced = 'No';
        }

        return $model;
    }

    public function applicationReadOnly($model) {
        return $model->isNewrecord || ($model->forwarded_by_secretary == 'Pending' && $model->forwarded_by_treasurer == 'Pending' && $model->approved_by_chairman == 'Pending') ? false : true;
    }

    /**
     * 
     * insert dates
     * @param type $model
     */
    public function witnessNguarantorDates($model) {
        $this->guarantorsOnlyOnAssetFinance($model);
        $model1 = LoanApplications::model()->findByPk($model->primaryKey);

        if (empty($model->witness))
            $model->witness_date = null;
        else
        if (empty($model1) || $model->witness != $model1->witness)
            $model->witness_date = date('Y') . '-' . date('m') . '-' . date('d');

        if (empty($model->guarantor1))
            $model->guarantor1_date = null;
        else
        if (empty($model1) || $model->guarantor1 != $model1->guarantor1)
            $model->guarantor1_date = date('Y') . '-' . date('m') . '-' . date('d');

        if (empty($model->guarantor2))
            $model->guarantor2_date = null;
        else
        if (empty($model1) || $model->guarantor2 != $model1->guarantor2)
            $model->guarantor2_date = date('Y') . '-' . date('m') . '-' . date('d');
    }

    /**
     * If loan type is not asset finance, then guarantors are not required
     * 
     * @param type $model
     */
    public function guarantorsOnlyOnAssetFinance($model) {
        if ($model->loan_type != 4) {
            $model->guarantor1 = null;
            $model->guarantor2 = null;
        }
    }

    /**
     * Establish applications requiring authority of current user
     */
    public function actionLoanApplications() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $loanApplications = $this->applications();

        if (!empty($_REQUEST['id']))
            $model = LoanApplications::model()->findByPk($_REQUEST['id']);

        $this->render('application.modules.users.views.default.default', array(
            'model' => $loanApplications,
            'others' => array('model' => empty($model) ? new LoanApplications : $model, 'authority' => Maofficio::model()->officio()),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Loan Applications',
            'render' => 'application.views.loanApplications.applications'
                )
        );
    }

    public function actionLoansMemberIsServicing($date) {
        if ($_POST['ContributionsByMembers']['contribution_type'] == 4) {
            $loansMemberIsServicing = LoanApplications::model()->memberHasLoans($_POST['ContributionsByMembers']['member']);
            $loansAmountDue = LoanApplications::model()->computeTotals($loansMemberIsServicing, $date);

            if ($loansAmountDue > 0)
                $this->renderPartial('application.views.loanApplications.servicingLoans', array('model' => new LoanRepayments, 'loansMemberIsServicing' => $loansMemberIsServicing, 'date' => $date));
            else
                echo '&nbsp;';
        } else
        if (!empty($_POST['ContributionsByMembers']['contribution_type']))
            $this->renderPartial('application.views.contributionsByMembers.amount', array('model' => new ContributionsByMembers));
        else
            echo '&nbsp;';
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
            $cri->condition = "witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && forwarded_by_treasurer!='Pending' && treasurer_date IS NOT NULL && closed!='Yes' && close_date IS NULL";
        } else {
            $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
            if (!empty($currentSecretary) && $currentSecretary->member == $id)
                $cri->condition = "witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_treasurer='Pending' && treasurer_date IS NULL && approved_by_chairman='Pending' && chairman_date IS NULL && closed!='Yes' && close_date IS NULL";
            else {
                $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
                if (!empty($currentTreasurer) && $currentTreasurer->member == $id)
                    $cri->condition = "witness>0 && (loan_type!=4 || (loan_type=4 && guarantor1>0 && guarantor2>0)) && forwarded_by_secretary!='Pending' && secretary_date IS NOT NULL && approved_by_chairman='Pending' && chairman_date IS NULL && closed!='Yes' && close_date IS NULL";
            }
        }

        $cri->order = 'witness_date DESC, secretary_date DESC, guarantor1_date DESC, guarantor2_date DESC, treasurer_date DESC, chairman_date DESC, loan_type ASC, id ASC';

        return LoanApplications::model()->findAll($cri);
    }

    /**
     * Save alterations
     */
    public function actionSave() {
        $model = LoanApplications::model()->findByPk($_POST['LoanApplications']['id']);

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

        if ($model->forwarded_by_secretary != $_POST['LoanApplications']['forwarded_by_secretary']) {
            $model->forwarded_by_secretary = $_POST['LoanApplications']['forwarded_by_secretary'];

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

        if ($model->forwarded_by_treasurer != $_POST['LoanApplications']['forwarded_by_treasurer']) {
            $model->forwarded_by_treasurer = $_POST['LoanApplications']['forwarded_by_treasurer'];

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

        if ($model->approved_by_chairman != $_POST['LoanApplications']['approved_by_chairman']) {
            $model->approved_by_chairman = $_POST['LoanApplications']['approved_by_chairman'];

            if ($model->approved_by_chairman == 'Pending')
                $model->chairman_date = null;
            else
                $model->chairman_date = date('Y') . '-' . date('m') . '-' . date('d');

            $save = $this->setFlash($model, $authority);
        }

        $this->closeApplication($model);

        return $save;
    }

    /**
     * 
     * @param int $member person id
     * @param string $authority authority for officio
     * @param string $status approve, forward, decline, withdraw, postpone
     * @return string mail sent or otherwise
     */
    public function sendMailToApplicant($member, $authority, $status) {
        /*
          $user = Users::model()->findByPk($member);
          $member = Person::model()->findByPk($member);

          $date = Defaults::dayName(date('w')) . ' ' . Defaults::monthName(date('m')) . ' ' . date('d') . ', ' . date('Y');

          $message = new YiiMailMessage();
          $message->view = 'test';
          $message->setTo(array($user->email => $member->first_name));
          $message->setFrom(array(Yii::app()->params['adminEmail'] => Yii::app()->params['adminName']));
          $message->setSubject('Loan Application');

          $emailBody = "<h1>Hello $member->first_name,</h1>"
          . "<p>"
          . "Your loan was $status by the $authority on $date."
          . "<br>"
          . Yii::app()->params['adminName']
          . "</p>";

          $message->setBody(array($emailBody), 'text/html');

          if (Yii::app()->mail->send($message))
          return 'Mail sent to applicant.';
         */
    }

    /**
     * Close a loan application so it won't be further edited
     * 
     * @param type $model
     */
    public function closeApplication($model) {
        if ($model->closed != $_POST['LoanApplications']['closed']) {
            $model->closed = $_POST['LoanApplications']['closed'];

            if ($model->closed != 'Yes')
                $model->close_date = null;
            else
                $model->close_date = date('Y') . '-' . date('m') . '-' . date('d');

            if ($model->save()) {
                Expenditures::model()->loanApplicationIsExpense($model);
                $this->sendMailToApplicant($model->member, 'chairman', 'closed');
            } else {
                $model->closed = 'No';
                $model->close_date = null;
            }
        }
    }

    /**
     * Return a message on successful model save or otherwise
     * 
     * @param \LoanApplications $model model
     * @param type $authority
     * @return boolean
     */
    public function setFlash($model, $authority) {
        if ($model->save()) {
            $flash = 'The application has been';
            if ($authority != 'chairman')
                $status = ($authority == 'secretary' && $model->forwarded_by_secretary == 'Yes') || ($authority == 'treasurer' && $model->forwarded_by_treasurer == 'Yes') ?
                        'forwarded' :
                        (
                        ($authority == 'secretary' && $model->forwarded_by_secretary == 'No') || ($authority == 'treasurer' && $model->forwarded_by_treasurer == 'No') ?
                                'declined' : 'withdrawn'
                        );
            else
                $status = $model->approved_by_chairman == 'Yes' ? 'approved' :
                        ($model->approved_by_chairman == 'No' ? 'declined' : 'withdrawn');

            $mail = $this->sendMailToApplicant($model->member, $authority, $status);

            Yii::app()->user->setFlash('saved', "$flash $status. $mail");

            return true;
        } else
            Yii::app()->user->setFlash('saved', 'The alteration has not been captured');

        return false;
    }

    /**
     * print loan application
     * 
     * @param int $id loan application id
     */
    public function actionPrintLoan($id) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Loan Application', 'application.views.pdf.loanApplication', array('loan' => LoanApplications::model()->findByPk($id)), 'Loan Application'
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

        if (isset($_POST['LoanApplications'])) {
            $model->attributes = $_POST['LoanApplications'];
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
        $dataProvider = new CActiveDataProvider('LoanApplications');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new LoanApplications('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LoanApplications']))
            $model->attributes = $_GET['LoanApplications'];

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LoanApplications the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LoanApplications::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LoanApplications $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loan-applications-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Search criteria for witness and guarantors
     * 
     * @param type $condition
     * @param type $params
     * @return type
     */
    public function searchCriteria($condition, $params) {
        $cri = new CDbCriteria;
        $cri->condition = $condition;
        $cri->params = $params;
        $cri->order = 'last_name ASC';

        $data = Person::model()->onlyActiveMembers(Person::model()->findAll($cri));

        foreach ($data as $i => $member) {
            $mbrshp = empty($member->membershipno) ? null : " - $member->membershipno";
            $data[$i]->last_name = "$member->last_name $member->first_name $member->middle_name$mbrshp";
        }

        return $data;
    }

    /**
     * dropDownLists for guarantor1
     */
    public function actionGuarantor() {
        $data = $this->searchCriteria($condition = 'id!=:id && id!=:id1', $params = array(':id' => $_POST['LoanApplications']['member'], ':id1' => $_POST['LoanApplications']['witness']));
        $this->dropDownList($data, 'guarantor1');
    }

    /**
     * dropDownLists for guarantor2
     */
    public function actionGuarantor1() {
        $data = $this->searchCriteria($condition = 'id!=:id && id!=:id1 && id!=:id2', $params = array(':id' => $_POST['LoanApplications']['member'], ':id1' => $_POST['LoanApplications']['witness'], ':id2' => $_POST['LoanApplications']['guarantor1']));
        $this->dropDownList($data, 'guarantor2');
    }

    /**
     * 
     * @param int $member person id
     * @param int $witness person id
     * @param int $otherGaranta person id
     * @return list persons - possible guarantors
     */
    public function otherGaranta($member, $witness, $otherGaranta) {
        $data = empty($otherGaranta) && empty($witness) ?
                $this->searchCriteria($condition = 'id!=:id', array(':id' => $member)) :
                (
                empty($otherGaranta) ?
                        $this->searchCriteria($condition = 'id!=:id && id!=:id1', array(':id' => $member, ':id1' => $witness)) :
                        (
                        empty($witness) ?
                                $this->searchCriteria($condition = 'id!=:id && id!=:id1', array(':id' => $member, ':id1' => $otherGaranta)) :
                                $this->searchCriteria($condition = 'id!=:id && id!=:id1 && id!=:id2', array(':id' => $member, ':id1' => $witness, ':id2' => $otherGaranta))
                        )
                );
        return CHtml::listData($data, 'id', 'last_name');
    }

    /**
     * execute dropDownList
     * 
     * @param type $data
     * @param type $guarantor
     */
    public function dropDownList($data, $guarantor) {
        $data = CHtml::listData($data, 'id', 'last_name');
        $prompt = LoanApplications::model()->getAttributeLabel($guarantor);
        echo "<option value=''>-- $prompt --</option>";
        foreach ($data as $value => $type)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($type), true);
    }

    /**
     * Require relevant loan attributes depending on loan type
     */
    public function actionRenderPartialForm() {
        $array = isset($_REQUEST['loniSi']) && !empty($_REQUEST['source']) ? $this->pseudoInitialize($_REQUEST['loniSi'], $_REQUEST['member']) : $this->initialize();

        $this->renderPartial('table', array(
            'model' => $array['model'],
            'others' => array(
                'readOnly' => $array['readOnly'],
                'source' => empty($_REQUEST['source']) ?
                        null :
                        $_REQUEST['source']
            ),
                )
        );
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

    public function actionAllMembersLoans($member) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && forwarded_by_secretary='Yes' && forwarded_by_treasurer='Yes' && approved_by_chairman='Yes' && closed='Yes'";
        $cri->params = array(':mbr' => $member);
        $cri->order = 'close_date DESC, chairman_date DESC, witness_date DESC';

        $this->renderPartial('loansList', array('loans' => LoanApplications::model()->findAll($cri)));
    }

}
