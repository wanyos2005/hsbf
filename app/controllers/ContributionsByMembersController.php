<?php

class ContributionsByMembersController extends Controller {
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
                'actions' => array('create', 'update', 'contributionType', 'memberStatementsOfAccounts', 'myReceipts', 'printReceipts', 'whichStatement', 'saveBankPayments'),
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
        $model = new ContributionsByMembers;
        $loanRepayment = new LoanRepayments;
        $loansMemberIsServicing = array();

        $model->date = date('Y') . '-' . date('m') . '-' . date('d');
        $model->receiptno = empty($model->receiptno) ? NextReceiptNo::model()->receiptNo() : $model->receiptno;

        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST[$modelName = get_class($model)])) {
            $model->attributes = $_POST[$modelName];

            $nope = false;
            if (isset($_POST[$repaymentName = get_class($loanRepayment)]))
                foreach ($_POST[$repaymentName] as $loanApplicationId => $loanMemberIsServicing) {
                    $loansMemberIsServicing[$loanApplicationId] = new $repaymentName;
                    $loansMemberIsServicing[$loanApplicationId]->attributes = $loanMemberIsServicing;
                    $paidIn = $loansMemberIsServicing[$loanApplicationId]->amountrecovered;

                    if (!is_null($paidIn) && (!is_numeric($paidIn) || $paidIn <= 0) && $paidIn != '')
                        $loansMemberIsServicing[$loanApplicationId]->addError('amountrecovered', 'Invalid Entry!');
                    else
                    if (ceil($loansMemberIsServicing[$loanApplicationId]->balance) < $paidIn)
                        $loansMemberIsServicing[$loanApplicationId]->addError('amountrecovered', 'Amount too much!');
                    
                    if ($loansMemberIsServicing[$loanApplicationId]->hasErrors('amountrecovered'))
                        $nope = true;
                    
                    $model->amount = $model->amount + $paidIn;
                }
            
            if ($model->validate(array('amount', 'payment_mode', 'transaction_no')) && !$nope ) {
                $model->rowsToCreate($model, $model->member, $model->contribution_type, $model->amount, $model->date, $model->receiptno, $loansMemberIsServicing);
                $this->refresh();
            }
        }

        $this->render('application.modules.users.views.default.default', array(
            'model' => $model,
            'others' => array('loanRepayment' => $loanRepayment, 'loansMemberIsServicing' => $loansMemberIsServicing),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Member Contributions and Savings',
            'render' => 'application.views.contributionsByMembers.create'
                )
        );
    }

    /**
     * display types of statements available
     */
    public function actionMemberStatementsOfAccounts() {
        $id = Yii::app()->user->id;
        $user_model = Users::model()->loadModel($id);
        $person_model = Person::model()->loadModel($id);

        $this->render('application.modules.users.views.default.default', array(
            'model' => null,
            'others' => array(),
            'user_model' => $user_model,
            'person_model' => $person_model,
            'title' => 'Statements of Accounts',
            'render' => 'application.views.contributionsByMembers.statements'
                )
        );
    }

    public function actionMyReceipts($id) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && receiptno!='' && receiptno IS NOT null && (receiptno_again='' || receiptno_again IS null)";
        $cri->params = array(':mbr' => $id);
        $cri->order = 'date DESC, receiptno DESC';

        $this->renderPartial('myReceipts', array(
            'receipts' => ContributionsByMembers::model()->findAll($cri)
                )
        );
    }

    /**
     * 
     * @param int $bala receipt no
     */
    public function actionPrintReceipts($bala) {
        $this->pageTitle = 'Receipt Acknowledgement';
        NextReceiptNo::model()->printReceipts(array($bala));
    }

    /**
     * 
     * @param int $id person id
     * @param int $type type of contribution
     */
    public function actionWhichStatement($id, $type) {
        if ($type == 2)
            $this->monthlyContributionStatements($id);

        if ($type == 3)
            $this->savingsStatements($id);

        if ($type == 4)
            $this->loanStatements($id);
    }

    /**
     * 
     * @param int $id person id
     */
    public function monthlyContributionStatements($id) {
        $user_model = Users::model()->loadModel($id);

        $contributions = ContributionsByMembers::model()->orderReceiptNumbers(
                ContributionsByMembers::model()->totalMemberContributionBtwnDates(
                        $id, 2, $startDate = substr($user_model->date_created, 0, 10), $endDate = date('Y') . '-' . date('m') . '-' . date('d')
                ), $startDate, $endDate
        );

        $loanRecoveries = LoanRepayments::model()->memberLoanRepaymentsBtwnDates($id, $startDate, $endDate);

        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Monthly Contributions', 'application.views.pdf.monthlyContribution', array(
            'person' => Person::model()->loadModel($id),
            'totalContributions' => ContributionsByMembers::model()->membersContributionsBtwnDates(
                    $contributions, $loanRecoveries
            ),
            'transactions' => $this->orderTransactions(
                    $contributions, $loanRecoveries, $startDate, $endDate
            ),
            'endDate' => $endDate
                ), 'Monthly Contributions'
        );
    }

    /**
     * 
     * @param int $id person id
     */
    public function savingsStatements($id) {

        $evaluationDates = $this->orderEvaluationDates(
                $this->evaluationDates(
                        $savingsModels = Savings::model()->membersSavingsForStatement(
                        $id, $endDate = date('Y') . '-' . date('m') . '-' . date('d')
                        )
                )
        );

        $notWithdrawns = $this->savingsNotWithdrawnToDate($savingsModels);
        $depositsAndReinvestments = $this->isolateDepositsFromReinvestments($savingsModels);

        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Savings Account', 'application.views.pdf.savings', array(
            'person' => Person::model()->loadModel($id),
            'transactions' => $this->savingsTransactions(
                    $savingsModels, $depositsAndReinvestments, $notWithdrawns, $evaluationDates
            ),
            'endDate' => $endDate
                ), 'Savings Account'
        );
    }

    /**
     * 
     * @param int $id loan application id
     */
    public function loanStatements($id) {

        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Loan Repayment Statement', 'application.views.pdf.loanRepayment', array(
            'loanApplication' => $loanApplication = LoanApplications::model()->findByPk($id),
            'person' => Person::model()->loadModel($loanApplication->member),
            'transactions' => $this->orderLoanRepaymentTransactions(
                    LoanRepayments::model()->memberLoanRepaymentsBtwnDatesAgain(
                            $id, $startDate = $loanApplication->close_date, $endDate = date('Y') . '-' . date('m') . '-' . date('d')
                    ), $loanApplication, $startDate, $endDate
            ),
            'endDate' => $endDate
                ), 'Loan Repayment Statement'
        );
    }

    /**
     * 
     * @param \ContributionsByMembers $contributions models
     * @param \LoanRepayments $loanRecoveries models
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function orderTransactions($contributions, $loanRecoveries, $startDate, $endDate) {
        $transactions = array();

        while ($startDate <= $endDate) {
            foreach ($contributions as $c => $contribution)
                if ($contribution->date == $startDate) {
                    $transactions[$count = count($transactions)][ContributionsByMembers::DEPOSIT] = $contribution->amount;
                    $transactions[$count][ContributionsByMembers::WITHDRAWAL] = null;
                    $transactions[$count][ContributionsByMembers::RECEIPT] = $contribution->receiptno == ContributionsByMembers:: FALSE_RECEIPT ? null : $contribution->receiptno;
                    $transactions[$count][ContributionsByMembers::DATE] = $startDate;
                    unset($contributions[$c]);
                }

            foreach ($loanRecoveries as $l => $loanRecovery)
                if ($loanRecovery->recoverydate == $startDate) {
                    $transactions[$count = count($transactions)][ContributionsByMembers::WITHDRAWAL] = $loanRecovery->amountrecovered;
                    $transactions[$count][ContributionsByMembers::DEPOSIT] = null;
                    $transactions[$count][ContributionsByMembers::RECEIPT] = LoanRepayments::INSTEAD_OF_RECEIPT;
                    $transactions[$count][ContributionsByMembers::DATE] = $startDate;
                    unset($loanRecoveries[$l]);
                }

            $startDate = LoanApplications::model()->dayAfter($startDate);
        }

        return $transactions;
    }

    /**
     * 
     * @param \Savings $savingsModels models
     * @return array all possible dates when savings transactions occured
     */
    public function evaluationDates($savingsModels) {
        $dates = array();
        $prvsYear = date('Y');

        foreach ($savingsModels as $savingsModel) {
            if (!isset($dates[$savingsModel->date_of_investment]))
                $dates[$savingsModel->date_of_investment] = $savingsModel->date_of_investment;

            if (substr($savingsModel->date_of_investment, 0, 4) < $prvsYear)
                $prvsYear = substr($savingsModel->date_of_investment, 0, 4);
        }

        if ($prvsYear < $year = date('Y'))
            for ($prvsYear = $prvsYear; $prvsYear < $year; $prvsYear++)
                if (!isset($dates[$date = "$prvsYear-12-31"]))
                    $dates[$date] = $date;

        if (!isset($dates[$date = date('Y') . '-' . date('m') . '-' . date('d')]))
            $dates[$date] = $date;

        return $dates;
    }

    /**
     * 
     * @param array $dates
     * @return array dates ordered, ASC 
     */
    public function orderEvaluationDates($dates) {
        $minDate = min($dates);
        $maxDate = max($dates);

        while ($minDate <= $maxDate) {
            if (isset($dates[$minDate]))
                $newDates[$minDate] = $minDate;

            $minDate = LoanApplications::model()->dayAfter($minDate);
        }

        return empty($newDates) ? array() : $newDates;
    }

    /**
     * 
     * @param \Savings $savingsModels models
     * @return \Savings savings that have not been withdrawn to date
     */
    public function savingsNotWithdrawnToDate($savingsModels) {
        foreach ($savingsModels as $savingsModel)
            if (!empty($savingsModel->principal) && empty($savingsModel->accumulated_amount))
                $notWithdrawns[$savingsModel->primaryKey] = $savingsModel;

        return empty($notWithdrawns) ? array() : $notWithdrawns;
    }

    const REINVESTMENT = 'Reinvestment';

    /**
     * 
     * @param \Savings $savingsModels models
     * @return \Savings savings isolated into deposits or reinvestments
     */
    public function isolateDepositsFromReinvestments($savingsModels) {
        $newSavingsModels = array(ContributionsByMembers::DEPOSIT => array(), self::REINVESTMENT => array());

        foreach ($savingsModels as $savingsModel)
            if (!isset($deposits[$savingsModel->savings_id])) {
                $deposits[$savingsModel->savings_id] = $savingsModel->savings_id;
                $newSavingsModels[ContributionsByMembers::DEPOSIT][$savingsModel->primaryKey] = $savingsModel;
            } else
                $newSavingsModels[self::REINVESTMENT][$savingsModel->primaryKey] = $savingsModel;

        return $newSavingsModels;
    }

    /**
     * 
     * @param \Savings $savingsModels models
     * @param \Savings $depositsAndReinvestments savings isolated into deposits or reinvestments
     * @param \Savings $notWithdrawns savings that have not been withdrawn to date
     * @param array $evaluationDates dates when amounts are required 
     * @return array
     */
    public function savingsTransactions($savingsModels, $depositsAndReinvestments, $notWithdrawns, $evaluationDates) {
        $transactions = array();

        foreach ($evaluationDates as $evaluationDate) {
            $notWithdrawnsByThisDate = $this->savingsNotWithdrawnbyThisDate($savingsModels, $evaluationDate);
            $depositsMadeOnThisDate = $this->depositsOnThisDate($depositsAndReinvestments[ContributionsByMembers::DEPOSIT], $evaluationDate);
            $withdrawalsOnThisDate = $this->withdrawalsOnThisDate($savingsModels, $evaluationDate);

            $balanceCarriedForward = Savings::model()->computeTotalForOpenInvestments($notWithdrawnsByThisDate, $evaluationDate);
            $totalPrincipals = Savings::model()->totalDeposits($notWithdrawnsByThisDate);
            $totalDeposits = Savings::model()->totalDeposits($depositsMadeOnThisDate);
            $totalToDeductFrom = $balanceCarriedForward + $totalDeposits;

            $interest = round(isset($previousBalanceCarriedForward) ? $balanceCarriedForward - $previousBalanceCarriedForward : $balanceCarriedForward - $totalPrincipals, 3);

            if (isset($previousDate) && substr($previousDate, 0, 4) != substr($evaluationDate, 0, 4)) {
                $transactions[$count = count($transactions)] = $this->buildRow(
                        null, null, null, null, null, null, null, null
                        // $principal, $rate, $amount, $interest, $balance, $withdrawal, $receipt, $date
                );

                $style = true;
            }

            if ($balanceCarriedForward > 0) {
                $transactions[$count = count($transactions)] = $this->buildRow(
                        null, // $principal - or comment this statement and uncomment the next
                        //isset($previousBalanceCarriedForward) ? $previousBalanceCarriedForward : $balanceCarriedForward - $interest, // $principal - or comment this statement and uncomment one above
                        null, // $rate
                        $increasingAmount = $previousBalanceCarriedForward = $balanceCarriedForward, $interest, null, // $amount, $interest, $balance
                        null, Savings::INSTEAD_OF_RECEIPT, $evaluationDate // $withdrawal, $receipt, $date
                );

                if (isset($style)) {
                    $transactions[$count - 2][Savings::STYLE] = true;
                    unset($style);
                }
            }


            foreach ($depositsMadeOnThisDate as $depositMadeOnThisDate) {
                $contribution = ContributionsByMembers::model()->findByPk($depositMadeOnThisDate->savings_id);

                $transactions[$count = count($transactions)] = $this->buildRow(
                        $depositMadeOnThisDate->principal, $depositMadeOnThisDate->interest_rate_per_annum, // $principal, $rate
                        $increasingAmount = isset($increasingAmount) ? $increasingAmount + $depositMadeOnThisDate->principal : $depositMadeOnThisDate->principal, null, null, // $amount, $interest, $balance
                        null, $contribution->receiptno, $evaluationDate // $withdrawal, $receipt, $date
                );
            }

            if (!empty($withdrawalsOnThisDate)) {
                foreach ($withdrawalsOnThisDate as $withdrawalOnThisDate) {
                    $cashWithdrawal = CashWithdrawals::model()->findByPk($withdrawalOnThisDate->amount_withdrawn);

                    $transactions[$count = count($transactions)] = $this->buildRow(
                            null, null, null, null, // $principal, $rate, $amount, $interest
                            $previousBalanceCarriedForward = $totalToDeductFrom = $totalToDeductFrom - $amountWithdrawn = $withdrawalOnThisDate->accumulated_amount - $withdrawalOnThisDate->balance, //$balance
                            $amountWithdrawn, // $withdrawal
                            $cashWithdrawal->cash_or_cheque, $evaluationDate // $receipt, $date
                    );
                }

                $transactions[$count = count($transactions)] = $this->buildRow(
                        null, null, $transactions[$count - 1][Loanrepayments::REDUCING_BALANCE], null, // $principal, $rate, $amount, $interest
                        null, null, null, null //$balance, $withdrawal, $receipt, $date
                );
            }

            $previousDate = $evaluationDate;
        }
        if (!empty($transactions))
            $transactions[$count][Savings::STYLE] = true;

        return $transactions;
    }

    /**
     * 
     * @param double $principal principal
     * @param double $rate percent
     * @param double $amount amount
     * @param double $interest interest
     * @param double $balance balance
     * @param double $withdrawal withdrawal
     * @param string $receipt receipt no or otherwise
     * @param date $date
     * @return array row data
     */
    public function buildRow($principal, $rate, $amount, $interest, $balance, $withdrawal, $receipt, $date) {
        $transaction[LoanRepayments::PRINCIPAL] = $principal;
        $transaction[Savings::INTEREST_RATE] = $rate;
        $transaction[LoanRepayments::AMOUNT_DUE] = $amount;
        $transaction[LoanRepayments::INTEREST] = $interest;
        $transaction[LoanRepayments::REDUCING_BALANCE] = $balance;
        $transaction[ContributionsByMembers::WITHDRAWAL] = $withdrawal;

        $transaction[ContributionsByMembers::RECEIPT] = $receipt;
        $transaction[ContributionsByMembers::DATE] = $date;

        return $transaction;
    }

    /**
     * 
     * @param \Savings $savingsModels models
     * @param date $endDate
     * @return \Savings models - savings not withdrawn by this date
     */
    public function savingsNotWithdrawnbyThisDate($savingsModels, $endDate) {
        foreach ($savingsModels as $notWithdrawn)
            if ($notWithdrawn->date_of_investment < $endDate && (empty($notWithdrawn->date_of_withdrawal) || $notWithdrawn->date_of_withdrawal >= $endDate))
                $chosens[$notWithdrawn->primaryKey] = $notWithdrawn;

        return empty($chosens) ? array() : $chosens;
    }

    /**
     * 
     * @param \Savings $deposits models - deposits into savings
     * @param date $endDate
     * @return \Savings models - deposits on this date
     */
    public function depositsOnThisDate($deposits, $endDate) {
        foreach ($deposits as $deposit)
            if ($deposit->date_of_investment == $endDate)
                $chosens[$deposit->primaryKey] = $deposit;

        return empty($chosens) ? array() : $chosens;
    }

    /**
     * 
     * @param \Savings $savingsModels models
     * @param date $endDate
     * @return \Savings models - withdrawals from savings on this date
     */
    public function withdrawalsOnThisDate($savingsModels, $endDate) {
        foreach ($savingsModels as $savingsModel)
            if ($savingsModel->date_of_withdrawal == $endDate)
                $chosens[$savingsModel->primaryKey] = $savingsModel;

        return empty($chosens) ? array() : $chosens;
    }

    const REPAYMENTS = 'repayments';
    const RECOVERIES = 'recoveries';

    /**
     * 
     * @param \Loanrepayments $loanRepayments models
     * @param \Loanapplications $loanApplication models
     * @param \CashWithdrawals $withdrawals models
     * @param date $startDate
     * @param date $endDate
     * @return array
     */
    public function orderLoanRepaymentTransactions($loanRepayments, $loanApplication, $startDate, $endDate) {
        $transactions = array();
        $separations = $this->separateRecoveriesFromRepayments($loanRepayments);

        $transactions[$count = count($transactions)][Loanrepayments::PRINCIPAL] = $loanApplication->amout_borrowed;
        $transactions[$count][Loanrepayments::AMOUNT_DUE] = null;
        $transactions[$count][Loanrepayments::INTEREST] = null;
        $transactions[$count][Loanrepayments::AMOUNT_PAID] = null;
        $transactions[$count][Loanrepayments::DEDUCTION_FROM_CONTRIBUTIONS] = null;
        $transactions[$count][Loanrepayments::REDUCING_BALANCE] = round(
                LoanRepayments::model()->amountDue(
                        $loanApplication->amout_borrowed, $loanApplication->interest_rate, $loanApplication->close_date, $loanApplication->close_date, 0
                ), 3);
        $transactions[$count][ContributionsByMembers::RECEIPT] = null;
        $transactions[$count][ContributionsByMembers::DATE] = $loanApplication->close_date;

        while ($startDate <= $endDate) {
            foreach ($loanRepayments as $l => $loanRepayment) {
                if (!empty($loanRepayment->contribution_toward_loan))
                    if (isset($separations[self::REPAYMENTS][$loanRepayment->primaryKey])) {
                        $contribution = ContributionsByMembers::model()->findByPk($loanRepayment->contribution_toward_loan);
                        $repayment = $separations[self::REPAYMENTS][$loanRepayment->primaryKey];
                        if ($repayment->recoverydate == $startDate) {
                            $transactions[$count = count($transactions)][Loanrepayments::PRINCIPAL] = $transactions[$count - 1][LoanRepayments::REDUCING_BALANCE];
                            $transactions[$count][Loanrepayments::AMOUNT_DUE] = $loanRepayment->amount_due;
                            $transactions[$count][Loanrepayments::INTEREST] = round($transactions[$count][Loanrepayments::AMOUNT_DUE] - $transactions[$count][Loanrepayments::PRINCIPAL], 3);
                            //round($loanRepayment->amount_due - $transactions[$count - 1][LoanRepayments::REDUCING_BALANCE], 3);
                            $transactions[$count][Loanrepayments::AMOUNT_PAID] = $loanRepayment->amount_due - $loanRepayment->balance;
                            $transactions[$count][Loanrepayments::DEDUCTION_FROM_CONTRIBUTIONS] = null;
                            $transactions[$count][Loanrepayments::REDUCING_BALANCE] = $loanRepayment->balance;
                            $transactions[$count][ContributionsByMembers::RECEIPT] = $contribution->receiptno == ContributionsByMembers::FALSE_RECEIPT ? null : $contribution->receiptno;
                            $transactions[$count][ContributionsByMembers::DATE] = $startDate;
                        }
                    }

                if (isset($separations[self::RECOVERIES][$loanRepayment->primaryKey])) {
                    $contribution = ContributionsByMembers::model()->findByPk($loanRepayment->contribution_toward_loan);
                    $repayment = $separations[self::RECOVERIES][$loanRepayment->primaryKey];
                    if ($repayment->recoverydate == $startDate) {
                        $transactions[$count = count($transactions)][Loanrepayments::PRINCIPAL] = $transactions[$count - 1][LoanRepayments::REDUCING_BALANCE];
                        $transactions[$count][Loanrepayments::AMOUNT_DUE] = $loanRepayment->recoveryamount;
                        $transactions[$count][Loanrepayments::INTEREST] = round($transactions[$count][Loanrepayments::AMOUNT_DUE] - $transactions[$count][Loanrepayments::PRINCIPAL], 3);
                        //round($loanRepayment->recoveryamount - $transactions[$count - 1][LoanRepayments::REDUCING_BALANCE], 3);
                        $transactions[$count][Loanrepayments::AMOUNT_PAID] = null;
                        $transactions[$count][Loanrepayments::DEDUCTION_FROM_CONTRIBUTIONS] = $loanRepayment->amountrecovered;
                        $transactions[$count][Loanrepayments::REDUCING_BALANCE] = $loanRepayment->newbalance;
                        $transactions[$count][ContributionsByMembers::RECEIPT] = Loanrepayments::INSTEAD_OF_RECEIPT;
                        $transactions[$count][ContributionsByMembers::DATE] = $startDate;
                    }
                }
            }

            $startDate = LoanApplications::model()->dayAfter($startDate);
        }

        if (count($transactions) < 2) {
            $transactions[$count = count($transactions)][Loanrepayments::PRINCIPAL] = $transactions[$count - 1][LoanRepayments::REDUCING_BALANCE];
            $transactions[$count][Loanrepayments::AMOUNT_DUE] = round(
                    LoanRepayments::model()->amountDue(
                            $transactions[$count][Loanrepayments::PRINCIPAL], $loanApplication->interest_rate, $loanApplication->close_date, $endDate, $transactions[$count - 1][ContributionsByMembers::DATE] == $endDate ? 1 : 0
                    ), 3);
            $transactions[$count][Loanrepayments::INTEREST] = round($transactions[$count][Loanrepayments::AMOUNT_DUE] - $transactions[$count][Loanrepayments::PRINCIPAL], 3);
            $transactions[$count][Loanrepayments::AMOUNT_PAID] = null;
            $transactions[$count][Loanrepayments::DEDUCTION_FROM_CONTRIBUTIONS] = null;
            $transactions[$count][Loanrepayments::REDUCING_BALANCE] = $transactions[$count][Loanrepayments::AMOUNT_DUE];
            $transactions[$count][ContributionsByMembers::RECEIPT] = null;
            $transactions[$count][ContributionsByMembers::DATE] = $endDate;
        }

        return $transactions;
    }

    /**
     * 
     * @param \Loanrepayments $loanRepayments models
     * @return \Loanrepayments models
     */
    public function separateRecoveriesFromRepayments($loanRepayments) {
        $repayments = array();
        $recoveries = array();

        foreach ($loanRepayments as $repayment) {
            $repayments[$repayment->primaryKey] = $repayment;

            if ($repayment->recoveryamount > 0) {
                $recoveries[$repayment->primaryKey] = new LoanRepayments;
                $recoveries[$repayment->primaryKey]->attributes = $repayment->attributes;

                $contribution = ContributionsByMembers::model()->findByPk($repayment->contribution_toward_loan);
                $repayments[$repayment->primaryKey]->recoverydate = empty($contribution) ? $repayment->recoverydate : $contribution->date;
            }
        }

        return array(
            self::REPAYMENTS => $repayments,
            self::RECOVERIES => $recoveries
        );
    }

    /**
     * do the bank payment transfer into contributions
     */
    public function actionSaveBankPayments() {
        ContributionsByMembers::model()->bankPayments();
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

        if (isset($_POST['ContributionsByMembers'])) {
            $model->attributes = $_POST['ContributionsByMembers'];
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
        $dataProvider = new CActiveDataProvider('ContributionsByMembers');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ContributionsByMembers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ContributionsByMembers']))
            $model->attributes = $_GET['ContributionsByMembers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ContributionsByMembers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ContributionsByMembers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ContributionsByMembers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contributions-by-members-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * dropDownList for contribution
     */
    public function actionContributionType() {
        $data = ContributionsByMembers::model()->contributionType($_POST['ContributionsByMembers']['member']);
        $data = CHtml::listData($data, 'id', 'contribution_type');
        $prompt = ContributionTypes::model()->getAttributeLabel('contribution_type');
        echo "<option value=''>-- $prompt --</option>";
        foreach ($data as $value => $type)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($type), true);
    }

}
