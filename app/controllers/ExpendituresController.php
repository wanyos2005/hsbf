<?php

class ExpendituresController extends Controller {
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
                'actions' => array('create', 'update', 'incomeOrExpense', 'paymentJournals',
                    'whichJournal', 'cashBook', 'downloadCashBook', 'balanceSheet', 'downloadBalanceSheet',
                    'ledgerBook', 'downloadLedgerBook', 'trialBalance', 'downloadTrialBalance'),
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
        $this->pageTitle = 'Income and Expenditure';
        $id = Yii::app()->user->id;
        $income = new Incomes;
        $expenditure = new Expenditures;

        $this->performAjaxValidation(array($income, $expenditure));

        if (isset($_POST['Expenditures'])) {
            $income->attributes = $_POST['Expenditures'];
            if ($income->save())
                $this->refresh();
        }

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(
                Voteheads::INCOME => $income,
                Voteheads::EXPENSE => $expenditure
            ),
            'user_model' => Users::model()->loadModel($id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Cash Withdrawals',
            'render' => 'application.views.expenditures.create'
        ));
    }

    /**
     * save income or expenditure
     * 
     * @param int $member person id
     * @param string $type income or expense
     * @param string $heading depending on $type
     */
    public function actionIncomeOrExpense($member, $type, $heading) {
        $form = $this->beginWidget(
                'CActiveForm', array(
            'id' => 'expenditures-form',
            'enableAjaxValidation' => true,
                )
        );

        $model = $type == Voteheads::INCOME ? new Incomes : new Expenditures;

        if (isset($_POST[$className = get_class($model)])) {
            $model->attributes = $_POST[get_class($model)];
            $model->receipt_no = NextReceiptNo::model()->receiptNo();
            $model->cask_or_bank = ($className == 'Incomes' && $model->votehead == Incomes::WITHDRAWAL_FROM_BANK) ||
                    ($className == 'Expenditures' && $model->votehead == Expenditures::DEPOSIT_TO_BANK) ?
                    (ContributionsByMembers::PAYMENT_BY_CASH) : $model->cask_or_bank;
            $model->logged_in = Yii::app()->user->id;


            if ($model->save()) {
                NextReceiptNo::model()->updateNextReceiptNo($model->receipt_no);

                if ($className == 'Incomes' && $model->votehead == Incomes::WITHDRAWAL_FROM_BANK)
                    Expenditures::model()->depositIntoBankIsExpense($model);
                else
                if ($className == 'Expenditures' && $model->votehead == Expenditures::DEPOSIT_TO_BANK)
                    Incomes::model()->withdrawalFromBankIsIncome($model);

                $this->refresh();
            }
        }

        $this->renderPartial('fieldsTable', array(
            'form' => $form, 'model' => $model, 'heading' => $heading, 'user' => Users::model()->loadModel($member),
            'field' => $type, 'fieldType' => Voteheads::SELECT
                )
        );
    }

    /**
     * prepare interface for printing journals
     */
    public function actionPaymentJournals() {
        $this->pageTitle = 'Payment Journals';

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(
                'since' => Defaults::firstOfThisYear(),
                'till' => Defaults::today(),
                'type' => Voteheads::EXPENSE
            ),
            'user_model' => Users::model()->loadModel($id = Yii::app()->user->id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Payment Journals',
            'render' => 'application.views.expenditures.paymentJournals'
                )
        );
    }

    /**
     * prepare interface for printing cash book
     */
    public function actionCashBook() {
        $this->pageTitle = 'Cash Books';

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(
                'since' => Defaults::firstOfThisYear(),
                'till' => Defaults::today(),
            ),
            'user_model' => Users::model()->loadModel($id = Yii::app()->user->id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Cash Books',
            'render' => 'application.views.incomes.cashBook'
                )
        );
    }

    public function actionBalanceSheet() {
        $this->pageTitle = 'Balance Sheet';

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(
                'since' => Defaults::firstOfThisYear(),
                'till' => Defaults::today(),
            ),
            'user_model' => Users::model()->loadModel($id = Yii::app()->user->id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Balance Sheets',
            'render' => 'application.views.incomes.balanceSheet'
                )
        );
    }

    public function actionTrialBalance() {
        $this->pageTitle = 'Trial Balance';

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array('till' => Defaults::today()),
            'user_model' => Users::model()->loadModel($id = Yii::app()->user->id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Trial Balances',
            'render' => 'application.views.incomes.trialBalance'
                )
        );
    }

    public function actionLedgerBook() {
        $this->pageTitle = 'Ledger Books';

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(
                'member' => $id = Yii::app()->user->id,
                'since' => Defaults::firstOfThisYear(),
                'till' => Defaults::today(),
            ),
            'user_model' => Users::model()->loadModel($id),
            'person_model' => Person::model()->loadModel($id),
            'title' => 'Ledger Books',
            'render' => 'application.views.incomes.ledgerBook'
                )
        );
    }

    /**
     * download cash book
     */
    public function actionDownloadCashBook() {
        Incomes::model()->printCashBook($_POST['since'], $_POST['till']);
    }

    /**
     * download cash book
     */
    public function actionDownloadBalanceSheet() {
        Incomes::model()->printBalanceSheet($_POST['since'], $_POST['till']);
    }

    /**
     * download ledger book
     */
    public function actionDownloadLedgerBook() {
        if (!empty($_POST['member']))
            Incomes::model()->printLedgerBook(
                    $_POST['member'] == Incomes::CASH_ACCOUNT ?
                            (ContributionsByMembers::PAYMENT_BY_CASH) :
                            (
                            $_POST['member'] == Incomes::BANK_ACCOUNT ?
                                    ContributionsByMembers::PAYMENT_BY_BANK : $_POST['member']
                            ), $_POST['since'], $_POST['till']);
    }

    /**
     * download cash book
     */
    public function actionDownloadTrialBalance() {
        Incomes::model()->printTrialBalance($_POST['till']);
    }

    /**
     * type of journal to generate
     */
    public function actionWhichJournal() {
        $dates = self::orderDates();

        switch ($_POST['type']) {
            case Voteheads::EXPENSE: Expenditures::model()->printExpenditureJournal($dates['since'], $dates['till']);
                break;
            case Voteheads::INCOME: Incomes::model()->printIncomeJournal($dates['since'], $dates['till']);
                break;

            default: Expenditures::model()->printExpenditureJournal($dates['since'], $dates['till']);
                break;
        }
    }

    /**
     * 
     * @return array dates - since, till
     */
    public static function orderDates() {
        $since = Defaults::firstOfThisYear();
        $till = Defaults::today();

        if (!empty($_POST['since']) && $_POST['since'] <= Defaults::today())
            $since = $_POST['since'];

        if (!empty($_POST['till']) && $_POST['till'] <= Defaults::today())
            $till = $_POST['till'];

        if ($since > $till) {
            $inter = $till;
            $till = $since;
            $since = $inter;
        }

        return array('since' => $since, 'till' => $till);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation(array($model));

        if (isset($_POST['Expenditures'])) {
            $model->attributes = $_POST['Expenditures'];
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
        $dataProvider = new CActiveDataProvider('Expenditures');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Expenditures('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Expenditures']))
            $model->attributes = $_GET['Expenditures'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Expenditures the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Expenditures::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Expenditures $model the model to be validated
     */
    protected function performAjaxValidation($models) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'expenditures-form') {
            echo CActiveForm::validate($models);
            Yii::app()->end();
        }
    }

}
