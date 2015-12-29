<?php

/**
 * This is the model class for table "loan_repayments".
 *
 * The followings are the available columns in table 'loan_repayments':
 * @property integer $id
 * @property string $loan_application
 * @property string $contribution_toward_loan
 * @property string $amount_due
 * @property string $balance
 * @property string $recoveryamount
 * @property string $amountrecovered
 * @property string $newbalance
 * @property string $recoverydate
 */
class LoanRepayments extends CActiveRecord {

    const INSTEAD_OF_RECEIPT = 'Loan Recovery';
    const PRINCIPAL = 'Principal';
    const INTEREST = 'Interest';
    const AMOUNT_DUE = 'Amount Due';
    const REDUCING_BALANCE = 'Reducing Balance';
    const AMOUNT_PAID = 'Amount Paid';
    const DEDUCTION_FROM_CONTRIBUTIONS = 'Contributions Deduction';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'loan_repayments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('loan_application, contribution_toward_loan, amount_due, balance', 'required'),
            array('loan_application, contribution_toward_loan, amount_due, balance, recoveryamount, amountrecovered, newbalance', 'length', 'max' => 11),
            array('recoverydate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, loan_application, contribution_toward_loan, amount_due, balance, recoveryamount, amountrecovered, newbalance, recoverydate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'loan_application' => 'Loan Application',
            'contribution_toward_loan' => 'Contribution Toward Loan',
            'amount_due' => 'Amount Due',
            'balance' => 'Balance',
            'recoveryamount' => 'Amount To Be Recovered',
            'amountrecovered' => 'Amount Recovered',
            'newbalance' => 'Balance After Loan Recovery',
            'recoverydate' => 'Loan Recovery Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('loan_application', $this->loan_application, true);
        $criteria->compare('contribution_toward_loan', $this->contribution_toward_loan, true);
        $criteria->compare('amount_due', $this->amount_due, true);
        $criteria->compare('balance', $this->balance, true);
        $criteria->compare('recoveryamount', $this->recoveryamount, true);
        $criteria->compare('amountrecovered', $this->amountrecovered, true);
        $criteria->compare('newbalance', $this->newbalance, true);
        $criteria->compare('recoverydate', $this->recoverydate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LoanRepayments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Save loan repayment conditionally
     * then establish whether to do any loan recoveries
     * 
     * @param \LoanRepayments $model
     */
    public function modelSave($model) {
        if ($model->isNewRecord && empty($model->amount_due))
            ; //don't save
        else {
            if ($model->save())
                if ($this->thisIsTheLastRepaymentAsAtThisRecoveryDateTowardCorrespondingLoan($model) == true)
                    if (LoanApplications::model()->loanIsDue(
                                    $loan = LoanApplications::model()->findByPk($model->loan_application), //
                                    $loan->repaymentDate($loan->borrowingDate($loan), $loan->repayment_period)
                            )
                    )
                        $this->updateThisAndSubsequentLoanRecoveries($model);
        }
    }

    /**
     * Recompute loan recoveries.
     * 
     * @param \LoanRepayments $repayment
     */
    public function updateThisAndSubsequentLoanRecoveries($repayment) {
        $cri = new CDbCriteria;
        $cri->condition = 'id>=:id && loan_application=:loan && recoverydate>=:dt';
        $cri->params = array(':id' => $repayment->primaryKey, ':loan' => $repayment->loan_application, ':dt' => $repayment->recoverydate);
        $cri->order = 'recoverydate ASC';

        foreach (LoanRepayments::model()->findAll($cri) as $repayment) {
            $loanApplicationDue = LoanApplications::model()->returnALoanApplication($repayment->loan_application);

            $repaymentDate = $this->repaymentDate($repayment, $loanApplicationDue);

            $loanApplicationsDue = LoanApplications::model()->findLoansOverDueAsAtThisDate($repaymentDate);

            foreach ($loanApplicationsDue as $loanApplicationDue)
                if ($loanApplicationDue->primaryKey == $repayment->loan_application)
                    $this->computeRecoveries($this->lastLoanRepayment($loanApplicationDue, $repaymentDate));
        }
    }

    /**
     * If loan repayment date exceeds repayment date due,
     * then we adopt the repayment date as the date due.
     * 
     * @param \LoanRepayments $repayment Loan repayment
     * @param \LoanApplications $loanApplicationDue Loan application
     * @return date Date up to which to execute loan recovery.
     */
    public function repaymentDate($repayment, $loanApplicationDue) {
        $repaymentDate = LoanApplications::model()->repaymentDate(
                $loanApplicationDue->borrowingDate($loanApplicationDue), LoanApplications::model()->recoverLoanAfterLoanRepaymentPeriod() == true ?
                        $loanApplicationDue->repayment_period : $loanApplicationDue->max_repayment_period
        );

        return $repayment->recoverydate > $repaymentDate ? $repayment->recoverydate : $repaymentDate;
    }

    /**
     * Gather relevant parameters to process a loan repayment.
     * 
     * @param \ContributionsByMembers $contribution loan repayment
     * @param \LoanRepayments $correspondingRepayment
     */
    public function repaymentRequirements($contribution, $correspondingRepayment) {
        $splitPiece = ContributionsByMembers::model()->findTheSplitContribution($contribution);
        $contribution->amount = $contribution->amount + $splitPiece->amount;
        $splitPiece->amount = 0;

        if (empty($correspondingRepayment->loan_application))
            $loanApplication = LoanApplications::model()->memberHasLoan($contribution->member);
        else
            $loanApplication = LoanApplications::model()->returnALoanApplication($correspondingRepayment->loan_application);

        $this->repaymentContribution($contribution, $splitPiece, $loanApplication, $correspondingRepayment);
    }

    /**
     * Record a loan repayment.
     * 
     * @param \ContributionsByMembers $contribution
     * @param \ContributionsByMembers $splitPiece
     * @param \LoanApplications $application
     * @param \Loans $loantype
     * @param \LoanRepayments $correspondingRepayment
     */
    public function repaymentContribution($contribution, $splitPiece, $application, $correspondingRepayment) {

        $correspondingRepayment->loan_application = $correspondingRepayment->isNewRecord ? $application->primaryKey : $correspondingRepayment->loan_application;

        $correspondingRepayment->amount_due = $this->computeAmountDue($this->previousRepayment($correspondingRepayment), $application, $contribution->date);

        $correspondingRepayment->balance = round($correspondingRepayment->amount_due - $contribution->amount, 3);

        $this->recoveryNotAtThisStage($correspondingRepayment);

        $this->overPaymentIsMonthlyContribution($correspondingRepayment, $contribution, $splitPiece);

        $this->saveAlterations($correspondingRepayment, $contribution, $splitPiece, $application);
    }

    /**
     * Save the parameters corresponding to the loan repayment.
     * 
     * @param \LoanRepayments $correspondingRepayment
     * @param \ContributionsByMembers $contribution
     * @param \ContributionsByMembers $splitPiece
     * @param \LoanApplications $application
     */
    public function saveAlterations($correspondingRepayment, $contribution, $splitPiece, $application) {
        $this->serviceLoanApplication($correspondingRepayment, $application);

        $this->modelSave($correspondingRepayment);

        ContributionsByMembers::model()->modelSave($splitPiece, false);

        ContributionsByMembers::model()->modelSave($contribution, false);
    }

    /**
     * In case of loan over repayment,
     * save over repayment as monthly contribution, $splitPiece.
     * 
     * @param \LoanRepayments $correspondingRepayment
     * @param \ContributionsByMembers $contribution
     * @param \ContributionsByMembers $splitPiece
     */
    public function overPaymentIsMonthlyContribution($correspondingRepayment, $contribution, $splitPiece) {
        if ($correspondingRepayment->balance < 0) {
            $splitPiece->amount = abs($correspondingRepayment->balance);
            $contribution->amount = $contribution->amount - $splitPiece->amount;

            if ($contribution->amount <= 0 && $splitPiece->amount > 0) {
                $contribution->amount = $splitPiece->amount + $contribution->amount;
                $splitPiece->amount = $contribution->amount - $splitPiece->amount;

                $this->probablyPreviousMonthlyContribution($contribution);

                $contribution->amount = 0;
            }

            if ($splitPiece->amount < 0)
                $splitPiece->amount = 0;

            $correspondingRepayment->balance = 0;
            $contribution->amount = round($contribution->amount, 3);
            $splitPiece->amount = round($splitPiece->amount, 3);
        }
    }

    /**
     * this loan over repayment is probably deducted from a previous receipt
     * rather than this current one
     * 
     * @param \ContributionsByMembers $contribution model
     */
    public function probablyPreviousMonthlyContribution($contribution) {
        if ($contribution->amount > 0) {
            $theJustPrecedingContribution = $contribution->theJustPrecedingContribution($contribution->member, 2, $contribution->date, $contribution->receiptno);

            if (empty($theJustPrecedingContribution)) {
                //very unlikely to occur couz an over repayment occurs when there have been a previous payment
                $theJustPrecedingContribution = new ContributionsByMembers;
                $theJustPrecedingContribution->attributes = $contribution->attributes;
                $theJustPrecedingContribution->contribution_type = 2;
                $theJustPrecedingContribution->date = date('Y') . '-' . date('m') . '-' . date('d');
                $theJustPrecedingContribution->amount = 0;
                $theJustPrecedingContribution->receiptno = ContributionsByMembers::FALSE_RECEIPT;
                $theJustPrecedingContribution->receiptno_again = $theJustPrecedingContribution->receiptno;
            }

            $theJustPrecedingContribution->amount = $theJustPrecedingContribution->amount + $contribution->amount;
            $theJustPrecedingContribution->save(false);
        }
    }

    /**
     * Update subsequent loan values in case of a contribution update.
     * 
     * @param \ContributionsByMembers $contribution A contribution toward loan repayment.
     */
    public function updateRepayments($contribution) {

        $correspondingRepayment = $this->contributionHasRepayment($contribution);

        if ($correspondingRepayment->isNewRecord)
            $this->repaymentRequirements($contribution, $correspondingRepayment);
        else {
            $correspondingRepayments = $this->thisAndSubsequentRepayments($correspondingRepayment);

            foreach ($correspondingRepayments as $correspondingRepayment) {
                $contribution = ContributionsByMembers::model()->returnAContribution($correspondingRepayment->contribution_toward_loan);
                $this->repaymentRequirements($contribution, $correspondingRepayment);
            }
        }
    }

    /**
     * Return current and subsequent repayments
     * 
     * @param \LoanRepayments $correspondingRepayment
     * @return \LoanRepayments
     */
    public function thisAndSubsequentRepayments($correspondingRepayment) {
        $cri = new CDbCriteria;
        $cri->condition = 'loan_application=:aplctn && id>=:id && recoverydate>=:dt';
        $cri->params = array(':aplctn' => $correspondingRepayment->loan_application, ':id' => $correspondingRepayment->primaryKey, ':dt' => $correspondingRepayment->recoverydate);
        $cri->order = 'recoverydate ASC, id ASC';

        return LoanRepayments::model()->findAll($cri);
    }

    /**
     * Compute amount accrued on a principal using compound interest.
     * The interest rate is annual.
     * $startDate must be less than or equal to $endDate.
     * 
     * @param double $principal
     * @param double $annualRate
     * @param date $startDate
     * @param date $endDate
     * @return double amount
     */
    public function amountDue($principal, $annualRate, $startDate, $endDate) {
        $months = Defaults::countMonths($startDate, $endDate);
        return round($principal * pow(1 + $annualRate / 100, $months / 12), 3);
    }

// the old function amountDueOld($principal, $annualRate, $startDate, $endDate, $plusOneDay) computes amount daily 

    /**
     * Compute amount accrued on a principal using compound interest.
     * The interest rate is annual.
     * $startDate must be less than or equal to $endDate.
     * 
     * @param double $principal
     * @param double $annualRate
     * @param date $startDate
     * @param date $endDate
     * @param int $plusOneDay
     * @return double amount
     */
    public function amountDueOld($principal, $annualRate, $startDate, $endDate, $plusOneDay) {
        $noOfDays = Defaults::countdays($startDate, $endDate) + $plusOneDay;
        $years = 0;

        for ($year = substr($startDate, 0, 4); $year <= substr($endDate, 0, 4); $year++) {
            $daysInAYear = Defaults::daysInAYear($startDate);

            if ($noOfDays >= $daysInAYear) {
                $noOfDays = $noOfDays - $daysInAYear;
                $years++;
            }
        }

        $years = empty($daysInAYear) ? 0 : $years + $noOfDays / $daysInAYear;

        return round($principal * pow(1 + $annualRate / 100, $years), 3);
    }

    /**
     * Return a principal, date when it was invested and date when being repaid.
     * Principal is mainly the reducing balance of the loan
     * and investment date is the date at the instance of the balance in the repayment series.
     * If no repayment ever, then the loan application amount and date provide these two parameters.
     * Date being repaid is date of contribution toward loan repayment.
     * Upon being served, a loan immediately attracts a one day interest.
     * 
     * @param \LoanRepayments $previousRepayment
     * @param \LoanApplications $application
     * @param date $endDate
     * @return array()
     */
    public function initialParameters($previousRepayment, $application, $endDate) {

        if (!empty($previousRepayment))
            return array('principal' => $this->principal($previousRepayment), 'interest_rate' => $application->interest_rate, 'start_date' => $this->startDate($previousRepayment), 'end_date' => $endDate, 'plusOneDay' => 0);

        return array('principal' => $application->amout_borrowed, 'interest_rate' => $application->interest_rate, 'start_date' => $application->close_date, 'end_date' => $endDate, 'plusOneDay' => $endDate == $application->close_date ? 1 : 0);
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     * @return date Start counting reducing balance from this date.
     */
    public function startDate($repayment) {
        if (empty($repayment->recoveryamount))
            $correspondingContribution = ContributionsByMembers::model()->returnAContribution($repayment->contribution_toward_loan);

        return empty($repayment->recoveryamount) ? (empty($correspondingContribution) ? $repayment->recoverydate : $correspondingContribution->date) : ($repayment->recoverydate);
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     * @return double Determine principal amount between balance and new balance.
     */
    public function principal($repayment) {
        return empty($repayment->recoveryamount) ? $repayment->balance : $repayment->newbalance;
    }

    /**
     * If a contribution is recorded as a loan repayment, then return the repayment
     * else create and return a new repayment for it
     * 
     * @param \ContributionsByMembers $contribution
     * @return \LoanRepayments
     */
    public function contributionHasRepayment($contribution) {
        $repayment = LoanRepayments::model()->find('contribution_toward_loan=:ctrbtn', array(':ctrbtn' => $contribution->primaryKey));

        if (empty($repayment)) {
            $repayment = new LoanRepayments;
            $repayment->contribution_toward_loan = $contribution->primaryKey;
            $repayment->recoverydate = $contribution->date;
        }

        return $repayment;
    }

    /**
     * Establish the previous repayment just preceding this repayment
     * 
     * @param \LoanRepayments $repayment
     * @return \LoanRepayments
     */
    public function previousRepayment($repayment) {
        $cri = new CDbCriteria;
        $cri->condition = $repayment->isNewRecord ? 'loan_application=:loan' : 'recoverydate<:dt && loan_application=:loan';
        $cri->params = $repayment->isNewRecord ? array(':loan' => $repayment->loan_application) : array(':dt' => $repayment->recoverydate, ':loan' => $repayment->loan_application);
        $cri->order = 'recoverydate DESC, id DESC';

        foreach (LoanRepayments::model()->findAll($cri) as $repayment)
            return $repayment;
    }

    /**
     * Return last loan repayment by end of this date.
     * 
     * @param \LoanApplications $application Loan application.
     * @param date $endDate Latest loan repayment as at the end of this date.
     * @return \LoanRepayments
     */
    public function lastLoanRepayment($application, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'loan_application=:loan && recoverydate<=:dt';
        $cri->params = array(':loan' => $application->primaryKey, ':dt' => $endDate);
        $cri->order = 'recoverydate DESC, id DESC';

        foreach (LoanRepayments::model()->findAll($cri) as $repayment)
            return $repayment;
    }

    /**
     * Determine if this repayment is the last repayment.
     * 
     * @param \LoanRepayments $repayment
     * @return boolean TRUE: This $repayment is the last one. FALSE: This $repayment is not the last repayment.
     */
    public function thisIsTheLastRepaymentAsAtThisRecoveryDateTowardCorrespondingLoan($repayment) {
        $application = LoanApplications::model()->returnALoanApplication($repayment->loan_application);

        $repaymentDate = $this->repaymentDate($repayment, $application);

        $lastRepayment = $this->lastLoanRepayment($application, $repaymentDate);

        if (!$repayment->isNewRecord && $lastRepayment->primaryKey != $repayment->primaryKey) {
            $this->saveUpdate($repayment);

            return false;
        }

        return true;
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     */
    public function saveUpdate($repayment) {
        $this->recoveryNotAtThisStage($repayment);
        $this->updateRecoveryModel($repayment);
    }

    /**
     * Remove loan recovery details.
     * 
     * @param \LoanRepayments $repayment
     */
    public function recoveryNotAtThisStage($repayment) {
        $contribution = ContributionsByMembers::model()->returnAContribution($repayment->contribution_toward_loan);
        $repayment->recoveryamount = null;
        $repayment->amountrecovered = null;
        $repayment->newbalance = null;
        $repayment->recoverydate = $contribution->date;
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     */
    public function updateRecoveryModel($repayment) {
        $loanApplication = LoanApplications::model()->returnALoanApplication($repayment->loan_application);

        if ($repayment->isNewRecord)
            $repayment->save(false);
        else
            $repayment->update(array('recoveryamount', 'amountrecovered', 'newbalance', 'recoverydate'));

        $this->serviceLoanApplication($repayment, $loanApplication);
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     * @param \LoanApplications $loanApplication
     */
    public function serviceLoanApplication($repayment, $loanApplication) {
        if ($repayment->recoveryamount > 0)
            $loanApplication->serviced = $repayment->newbalance > 0 ? 'No' : 'Yes';
        else
            $loanApplication->serviced = $repayment->balance > 0 ? 'No' : 'Yes';

        $loanApplication->update(array('serviced'));
    }

    /**
     * Loan balance after this date.
     * Once again, a loan earns at least a one day interest.
     * 
     * @param \LoanApplications $application Loan application.
     * @param date $endDate
     * @return double
     */
    public function loanBalanceOfMemberAfterThisDate($application, $endDate) {
        return $this->computeAmountDue($this->lastLoanRepayment($application, $endDate), $application, $endDate);
    }

    /**
     * 
     * @param \LoanRepayments $repayment
     * @param \LoanApplications $application
     * @param date $endDate
     * @return double
     */
    public function computeAmountDue($repayment, $application, $endDate) {

        $initialParameters = $this->initialParameters($repayment, $application, $endDate);

        return $this->amountDue($initialParameters['principal'], $initialParameters['interest_rate'], $initialParameters['start_date'], $initialParameters['end_date'], $initialParameters['plusOneDay']);
    }

    /**
     * Recover over due loans as at this date.
     * 
     * @param date $dateDue
     */
    public function recoverLoans($dateDue) {
        $loanApplicationsDue = LoanApplications::model()->findLoansOverDueAsAtThisDate($dateDue);

        foreach ($loanApplicationsDue as $loanApplicationDue) {
            $effectiveRepaymentDate = LoanApplications::model()->dayBefore(
                    LoanApplications::model()->repaymentDate(
                            $loanApplicationDue->borrowingDate($loanApplicationDue), LoanApplications::model()->recoverLoanAfterLoanRepaymentPeriod() == true ?
                                    $loanApplicationDue->repayment_period : $loanApplicationDue->max_repayment_period
                    )
            );
            $lastRepayment = $this->lastLoanRepayment($loanApplicationDue, $effectiveRepaymentDate);

            if (empty($lastRepayment)) {

                $lastRepayment = new LoanRepayments;
                $lastRepayment->loan_application = $loanApplicationDue->primaryKey;
                $lastRepayment->amount_due = $this->amountDue($loanApplicationDue->amout_borrowed, $loanApplicationDue->interest_rate, $loanApplicationDue->close_date, $loanApplicationDue->close_date, 0);
                $lastRepayment->balance = $lastRepayment->amount_due;
                $lastRepayment->recoverydate = $loanApplicationDue->close_date; //date('Y') . '-' . date('m') . '-' . date('d');
            }

            $this->computeRecoveries($lastRepayment);
        }
    }

    /**
     * Compute loan recovery values.
     * 
     * @param \LoanRepayments $repayment
     */
    public function computeRecoveries($repayment) {
        $loanApplicationDue = LoanApplications::model()->returnALoanApplication($repayment->loan_application);
        $effectiveRepaymentDate = LoanApplications::model()->dayBefore(LoanApplications::model()->repaymentDate(
                        $loanApplicationDue->borrowingDate($loanApplicationDue), LoanApplications::model()->recoverLoanAfterLoanRepaymentPeriod() == true ?
                                $loanApplicationDue->repayment_period : $loanApplicationDue->max_repayment_period
                )
        );

        $effectiveRepaymentDate = $repayment->recoverydate > $effectiveRepaymentDate ? $repayment->recoverydate : $effectiveRepaymentDate;

        $amountDue = $this->computeAmountDue($repayment, $loanApplicationDue, LoanApplications::model()->repaymentDate(
                        $loanApplicationDue->borrowingDate($loanApplicationDue), LoanApplications::model()->recoverLoanAfterLoanRepaymentPeriod() == true ?
                                $loanApplicationDue->repayment_period : $loanApplicationDue->max_repayment_period
                )
        );
        $totalContributions = ContributionsByMembers::model()->totalMemberContribution($loanApplicationDue->member, 2, $effectiveRepaymentDate);
        $totalLoanRecoveries = $this->totalLoanRecoveries($loanApplicationDue->member, $effectiveRepaymentDate);
        $amountRecovered = $amountDue <= $totalContributions - $totalLoanRecoveries ? $amountDue : $totalContributions - $totalLoanRecoveries;

        $this->updateRecovery($repayment, $amountDue, $amountRecovered, $effectiveRepaymentDate);
    }

    /**
     * Update loan recovery.
     * 
     * @param \LoanRepayments $repayment
     * @param double $amountDue
     * @param double $amountRecovered
     * @param date $effectiveRepaymentDate
     */
    public function updateRecovery($repayment, $amountDue, $amountRecovered, $effectiveRepaymentDate) {
        $repayment->recoveryamount = $amountRecovered > 0 ? round($amountDue, 3) : null;
        $repayment->amountrecovered = $amountRecovered > 0 ? round($amountRecovered, 3) : null;
        $repayment->newbalance = $amountRecovered > 0 ? round($amountDue - $amountRecovered, 3) : null;
        $repayment->recoverydate = $amountRecovered > 0 ? $effectiveRepaymentDate : $repayment->recoverydate;

        $this->updateRecoveryModel($repayment);
    }

    /**
     * 
     * @param int $member
     * @param date $dateDue
     * @return double Total amount recovered into loans by end of this date
     */
    public function totalLoanRecoveries($member, $dateDue) {
        return
                $this->computeTotalLoanRecoveries(
                        LoanApplications::model()->allLoanRecoveriesOnAMember(
                                $member, $dateDue
                        ), $dateDue
                )
        ;
    }

    /**
     * 
     * @param \LoanApplications $loanApplications models
     * @param date $dateDue
     * @return double Total amount recovered into loans by end of this date
     */
    public function computeTotalLoanRecoveries($loanApplications, $dateDue) {
        $total = 0;

        foreach ($loanApplications as $application)
            $total = $total + $this->totalRecoveries($this->repaymentsTowardsLoanByEndofDate($application->primaryKey, $dateDue));

        return $total;
    }

    /**
     * 
     * @param \LoanRepayments $repayments models
     * @return double Total amount recovered
     */
    public function totalRecoveries($repayments) {
        $total = 0;

        foreach ($repayments as $repayment)
            $total = $total + $repayment->amountrecovered;

        return $total;
    }

    /**
     * 
     * @param int $applicationId loan application id
     * @param date $dateDue
     * @return \LoanRepayments models
     */
    public function repaymentsTowardsLoanByEndofDate($applicationId, $dateDue) {
        $repayments = $this->findAll(
                "amountrecovered>0 && amountrecovered!='' && loan_application=:loan && recoverydate<=:dt", array(
            ':loan' => $applicationId, ':dt' => $dateDue
                )
        );

        return empty($repayments) ? array() : $repayments;
    }

    /**
     * return only loan recoveries
     * 
     * @param int $member person id
     * @param date $startDate
     * @param date $endDate
     * @return \LoanRepayments models
     */
    public function memberLoanRepaymentsBtwnDates($member, $startDate, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = "amountrecovered>0 && amountrecovered!='' && recoverydate>=:dt && recoverydate<=:dt1";
        $cri->params = array(':dt' => $startDate, ':dt1' => $endDate);
        $cri->order = 'recoverydate ASC, id ASC';

        foreach ($repayments = $this->findAll($cri) as $r => $repayment) {
            $loanApplication = LoanApplications::model()->findByPk($repayment->loan_application);
            if ($loanApplication->member != $member)
                unset($repayments[$r]);
        }

        return empty($repayments) ? array() : $repayments;
    }

    /**
     * return loan repayments and recoveries
     * 
     * @param int $applicationId loan application id
     * @param date $startDate
     * @param date $endDate
     * @return \LoanRepayments models
     */
    public function memberLoanRepaymentsBtwnDatesAgain($applicationId, $startDate, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = "loan_application=:loan && (amount_due>0 || (amountrecovered>0 && amountrecovered!='' && recoverydate>=:dt && recoverydate<=:dt1))";
        $cri->params = array(':loan' => $applicationId, ':dt' => $startDate, ':dt1' => $endDate);
        $cri->order = 'recoverydate ASC, id ASC';

        $repayments = $this->findAll($cri);

        return empty($repayments) ? array() : $repayments;
    }

    /**
     * 
     * @param int $loanApplicationId loan application id
     * @param date $till yyyy-mm-dd
     * @return array loan values
     */
    public function profitEarnedOrToBeEarnedOnLoanBetweenAndIncludingTheseDates($loanApplicationId, $till) {
        if (is_object($loanApplication = LoanApplications::model()->returnALoanApplication($loanApplicationId)))
            return array(
                self::PRINCIPAL => $loanApplication->amout_borrowed,
                self::AMOUNT_PAID => $totalRepayments = $this->totalRecoveries($this->memberLoanRepaymentsBtwnDatesAgain($loanApplicationId, $loanApplication->close_date, $till)),
                self::REDUCING_BALANCE => $loanBalance = $this->loanBalanceOfMemberAfterThisDate($loanApplication, $till),
                self::AMOUNT_DUE => $accumulatedAmount = $totalRepayments + $loanBalance,
                self::INTEREST => round($accumulatedAmount - $loanApplication->amout_borrowed, 2)
            );

        return array();
    }

}
