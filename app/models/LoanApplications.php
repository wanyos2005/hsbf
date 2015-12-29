<?php

/**
 * This is the model class for table "loan_applications".
 *
 * The followings are the available columns in table 'loan_applications':
 * @property integer $id
 * @property integer $member
 * @property integer $loan_type
 * @property string $amout_borrowed
 * @property integer $repayment_period
 * @property double $interest_rate
 * @property integer $max_repayment_period
 * @property integer $witness
 * @property integer $guarantor1
 * @property integer $guarantor2
 * @property string $witness_date
 * @property string $guarantor1_date
 * @property string $guarantor2_date
 * @property string $forwarded_by_secretary
 * @property string $secretary_date
 * @property string $forwarded_by_treasurer
 * @property string $treasurer_date
 * @property string $approved_by_chairman
 * @property string $chairman_date
 * @property string $present_net_pay
 * @property string $basic_pay
 * @property string $payslip
 * @property string $net_pay_after_loan_repayment
 * @property string $closed
 * @property string $close_date
 * @property string $serviced
 */
class LoanApplications extends CActiveRecord {
    
    const LOAN_APPLICATION = 'Loan Application';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'loan_applications';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member, loan_type, amout_borrowed, repayment_period, present_net_pay, basic_pay, witness, serviced', 'required'),
            array('member, loan_type, repayment_period, max_repayment_period, witness, guarantor1, guarantor2', 'numerical', 'integerOnly' => true),
            array('amout_borrowed, present_net_pay, basic_pay, net_pay_after_loan_repayment', 'length', 'max' => 11),
            array('forwarded_by_secretary, forwarded_by_treasurer, approved_by_chairman, closed, serviced', 'length', 'max' => 10),
            array('loan_type', 'guarantorsOnAssetFinance'),
            array('interest_rate', 'numerical', 'min' => 0),
            array('payslip', 'length', 'max' => 128),
            array('amout_borrowed, basic_pay, present_net_pay', 'numerical', 'min' => 10),
            array('witness_date, guarantor1_date, guarantor2_date, secretary_date, treasurer_date, chairman_date, close_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member, loan_type, amout_borrowed, repayment_period, interest_rate, max_repayment_period, witness, guarantor1, guarantor2, witness_date, guarantor1_date, guarantor2_date, forwarded_by_secretary, secretary_date, forwarded_by_treasurer, treasurer_date, approved_by_chairman, chairman_date, present_net_pay, basic_pay, payslip, net_pay_after_loan_repayment, closed, close_date, serviced', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'member' => 'Member',
            'loan_type' => 'Loan Type',
            'amout_borrowed' => 'Amount Borrowed',
            'repayment_period' => 'Repayment Period',
            'interest_rate' => 'Interest Rate',
            'max_repayment_period' => 'Max Repayment Period',
            'witness' => 'Witness',
            'guarantor1' => 'Guarantor 1',
            'guarantor2' => 'Guarantor 2',
            'witness_date' => 'Witness Date',
            'guarantor1_date' => 'Guarantor 1 Date',
            'guarantor2_date' => 'Guarantor 2 Date',
            'forwarded_by_secretary' => 'Forwarded By Secretary',
            'secretary_date' => 'Secretary Date',
            'forwarded_by_treasurer' => 'Forwarded By Treasurer',
            'treasurer_date' => 'Treasurer Date',
            'approved_by_chairman' => 'Approved By Chairman',
            'chairman_date' => 'Chairman Date',
            'present_net_pay' => 'Present Net Pay',
            'basic_pay' => 'Basic Pay',
            'payslip' => 'Payslip',
            'net_pay_after_loan_repayment' => 'Net Pay After Loan Repayment',
            'closed' => 'Application Closed',
            'close_date' => 'Application Closed On',
            'serviced' => 'Serviced',
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
        $criteria->compare('member', $this->member);
        $criteria->compare('loan_type', $this->loan_type);
        $criteria->compare('amout_borrowed', $this->amout_borrowed, true);
        $criteria->compare('repayment_period', $this->repayment_period);
        $criteria->compare('interest_rate', $this->interest_rate);
        $criteria->compare('max_repayment_period', $this->max_repayment_period);
        $criteria->compare('witness', $this->witness);
        $criteria->compare('guarantor1', $this->guarantor1);
        $criteria->compare('guarantor2', $this->guarantor2);
        $criteria->compare('witness_date', $this->witness_date, true);
        $criteria->compare('guarantor1_date', $this->guarantor1_date, true);
        $criteria->compare('guarantor2_date', $this->guarantor2_date, true);
        $criteria->compare('forwarded_by_secretary', $this->forwarded_by_secretary, true);
        $criteria->compare('secretary_date', $this->secretary_date, true);
        $criteria->compare('forwarded_by_treasurer', $this->forwarded_by_treasurer, true);
        $criteria->compare('treasurer_date', $this->treasurer_date, true);
        $criteria->compare('approved_by_chairman', $this->approved_by_chairman, true);
        $criteria->compare('chairman_date', $this->chairman_date, true);
        $criteria->compare('present_net_pay', $this->present_net_pay, true);
        $criteria->compare('basic_pay', $this->basic_pay, true);
        $criteria->compare('payslip', $this->payslip, true);
        $criteria->compare('net_pay_after_loan_repayment', $this->net_pay_after_loan_repayment, true);
        $criteria->compare('closed', $this->closed, true);
        $criteria->compare('close_date', $this->close_date, true);
        $criteria->compare('serviced', $this->serviced, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LoanApplications the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Asset Finance must have two guarantors
     * 
     * @param type $attribute
     */
    public function guarantorsOnAssetFinance($attribute) {
        if ($this->$attribute == 4) {
            if (empty($this->guarantor1))
                $this->addError('guarantor1', $this->getAttributeLabel('guarantor1') . ' is required');
            if (empty($this->guarantor2))
                $this->addError('guarantor2', $this->getAttributeLabel('guarantor2') . ' is required');
        }

        $this->respectiveLoanParameters('loan_type');
    }

    /**
     * Analyze parameters that define applied loan
     * 
     * @param type $attribute
     */
    public function respectiveLoanParameters($attribute) {
        $this->net_pay_after_loan_repayment = null;
        $loan = Loans::model()->defaultLoanParameters($this->$attribute);

        if ($this->repayment_period > $loan->repayment_period)
            $this->addError('repayment_period', $this->getAttributeLabel('repayment_period') . " must not exceed $loan->repayment_period");

        if ($this->closed != 'Yes') {
            $this->interest_rate = $loan->interest_rate;
            $this->max_repayment_period = $loan->repayment_period;
        }

        $totalContributions = ContributionsByMembers::model()->netTotalMemberContribution($this->member, $this->borrowingDate($this));
        $available = Loans::model()->availableLoan($loan, $totalContributions);
        if ($this->amout_borrowed > $available)
            $this->addError('amout_borrowed', "Your available loan amount is KShs. $available");
        else
        if (!empty($this->amout_borrowed))
            if (empty($this->present_net_pay))
                $this->addError('amout_borrowed', $this->getAttributeLabel('present_net_pay') . " is required");
            else
            if (empty($this->repayment_period))
                $this->addError('amout_borrowed', $this->getAttributeLabel('repayment_period') . " is required");
            else {
                $amount = LoanRepayments::model()->amountDue($this->amout_borrowed, $this->interest_rate, $this->borrowingDate($this), $this->repaymentDate($this->borrowingDate($this), $this->repayment_period), 0);
                $monthlyRepaymentAmount = round($amount / $this->repayment_period, 2);
                if (Loans::model()->oneThirdRule($monthlyRepaymentAmount, $loan->one_third, $this->basic_pay) == true)
                    $this->addError('amout_borrowed', $this->getAttributeLabel('amout_borrowed') . " exceeds the One-Third Rule requirement");
                else
                    $this->net_pay_after_loan_repayment = $this->present_net_pay - $monthlyRepaymentAmount;
            }
    }

    /**
     * 
     * @param int $id person id
     * @return \Loanapplications models
     */
    public function membersPendingApplications($id) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && closed!='Yes'";
        $cri->params = array(':mbr' => $id);
        $cri->order = 'witness_date DESC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $member person id
     * @param boolean $newLoan true - add new loan
     * @return \LoanApplications models
     */
    public function loansBeingApplied($member, $newLoan) {
        $loanApplications = $this->membersPendingApplications($member);
        if (empty($loanApplications))
            $loanApplications = array();

        if ($newLoan == true)
            if ($this->veryNetTotalMemberContribution($member, $loanApplications, null) > 0) {
                $loanApplications[count($loanApplications)] = new LoanApplications;
                $loanApplications[count($loanApplications) - 1]->member = $member;
            }

        return $loanApplications;
    }

    /**
     * 
     * @param int $member person id
     * @param \Loanapplications $pendingLoanApplications models
     * @param int $excempt loan application id
     * @return double available loan amount
     */
    public function veryNetTotalMemberContribution($member, $pendingLoanApplications, $excempt) {
        $availableContributions = ContributionsByMembers::model()->netTotalMemberContribution($member, $endDate = date('Y') . '-' . date('m') . '-' . date('d'));

        if ($availableContributions > 0)
            foreach ($pendingLoanApplications as $pendingLoanApplication)
                if ($pendingLoanApplication->primaryKey != $excempt)
                    $availableContributions = $availableContributions - $pendingLoanApplication->amout_borrowed;

        if ($availableContributions < 0)
            $availableContributions = 0;

        return $availableContributions;
    }

    /**
     * Preferable loan borrowing date.
     * 
     * @param \LoanApplications $model
     * @return date
     */
    public function borrowingDate($model) {
        if (!empty($model->close_date))
            return $model->close_date;

        if (!empty($model->chairman_date))
            return $model->chairman_date;

        return $model->witness_date;
    }

    /**
     * Return an end date given a start date and duration in months.
     * 
     * @param date $borrowingDate yyyy-mm-dd
     * @param int $repaymentMonths Number of months
     * @return date yyyy-mm-dd
     */
    public function repaymentDate($borrowingDate, $repaymentMonths) {
        $endDate = Defaults::dateExplode($borrowingDate);
        $endDate['mth'] = $endDate['mth'] + $repaymentMonths;
        $endDate = Defaults::normalizeDate($endDate);

        return $endDate['yr'] . '-' . $endDate['mth'] . '-' . $endDate['dt'];
    }

    /**
     * Return a loan that a member is currently servicing
     * 
     * @param type $member
     * @return \LoanApplications
     */
    public function memberHasLoan($member) {
        $loans = $this->memberHasLoans($member);

        foreach ($loans as $loan)
            ;

        return empty($loan) ? null : $loan;
    }

    /**
     * 
     * @param int $member person id
     * @return boolean true - member has ever had a loan - whether or not serviced
     */
    public function memberHasALoan($member) {
        $loan = $this->find("member=:mbr && approved_by_chairman='Yes' && closed='Yes'", array(':mbr' => $member));
        return !empty($loan);
    }

    /**
     * Return all loan applications a member is currently servicing
     * 
     * @param type $member
     * @return \LoanApplications
     */
    public function memberHasLoans($member) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && approved_by_chairman='Yes' && closed='Yes' && serviced!='Yes'";
        $cri->params = array(':mbr' => $member);
        $cri->order = 'chairman_date DESC, close_date DESC';

        return LoanApplications::model()->findAll($cri);
    }

    /**
     * 
     * @param int $member Loanee
     * @param date $dateDue Effective loan repayment date
     * @return \LoanApplications Return all loans the member has ever had by the end of this date.
     */
    public function allLoanRecoveriesOnAMember($member, $dateDue) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && close_date<=:dt";
        $cri->params = array(':mbr' => $member, ':dt' => $dateDue);
        $cri->order = 'id DESC, close_date DESC';

        return LoanApplications::model()->findAll($cri);
    }

    /**
     * 
     * @param int $member Loanee
     * @param date $startDate any earlier date
     * @param date $dateDue Effective loan repayment date
     * @return \LoanApplications Return all loans by the member has ever had between two dates, both inclusive.
     */
    public function allLoanRecoveriesOnAMemberBtwnDates($member, $startDate, $dateDue) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && close_date>=:dt && close_date<=:dt1";
        $cri->params = array(':mbr' => $member, ':dt' => $startDate, ':dt1' => $dateDue);
        $cri->order = 'id DESC, close_date DESC';

        return LoanApplications::model()->findAll($cri);
    }

    /**
     * Compute all loan balances of a member end of this date.
     * 
     * @param int $member
     * @param date $endDate
     * @return double
     */
    public function totalLoanBalances($member, $endDate) {
        return $this->computeTotals($this->memberHasLoans($member), $endDate);
    }

    /**
     * 
     * @param int $member
     * @param date $startDate
     * @param date $endDate
     * @return \LoanApplications models
     */
    public function totalLoanBalancesBtwnDates($member, $startDate, $endDate) {
        foreach ($loans = $this->memberHasLoans($member) as $l => $loan)
            if ($loan->close_date < $startDate || $loan->close_date > $endDate)
                unset($loans[$l]);

        return empty($loans) ? array() : $loans;
    }

    /**
     * 
     * @param \LoanApplications $loans models
     * @param date $endDate
     * @return double
     */
    public function computeTotals($loans, $endDate) {
        $totalLoans = 0;

        foreach ($loans as $loan)
            $totalLoans = $totalLoans + LoanRepayments::model()->loanBalanceOfMemberAfterThisDate($loan, $endDate);

        return "$totalLoans";
    }

    /**
     * Return a required loan application
     * 
     * @param type $pk
     * @return \LoanApplications model
     */
    public function returnALoanApplication($pk) {
        return LoanApplications::model()->findByPk($pk);
    }

    /**
     * Return pending loan applications that have exceeded their due date.
     * 
     * @param date $dateDue yyyy-mm-dd
     * @return \LoanApplications Unserviced loan applications whose repayment date is less than @param date 
     */
    public function findLoansOverDueAsAtThisDate($dateDue) {
        $cri = new CDbCriteria;
        $cri->condition = "closed='Yes' && serviced!='Yes'";
        $cri->order = 'close_date ASC';

        $loans = LoanApplications::model()->findAll($cri);

        foreach ($loans as $l => $loan)
            if ($this->loanIsDue($loan, $dateDue) == false)
                unset($loans[$l]);

        return empty($loans) ? array() : $loans;
    }

    /**
     * Determine whether loan is due for recovery.
     * 
     * @param \LoanApplications $loan Loan application
     * @param date $dateDue Loan repayment date
     * @return boolean TRUE - $loan is due. FALSE - $loan is not due.
     */
    public function loanIsDue($loan, $dateDue) {
        $effectiveRepaymentDate = $this->dayBefore($this->repaymentDate($loan->borrowingDate($loan), $this->recoverLoanAfterLoanRepaymentPeriod() == true ? $loan->repayment_period : $loan->max_repayment_period));

        if ($effectiveRepaymentDate < $dateDue && $dateDue <= date('Y') . '-' . date('m') . '-' . date('d'))
            return true;
    }

    /**
     * Return day before today.
     * 
     * @param date $date
     * @return date
     */
    public function dayBefore($date) {
        $date = Defaults::dateExplode($date);
        $date['dt'] --;
        $date = Defaults::normalizeDate($date);

        return $date['yr'] . '-' . $date['mth'] . '-' . $date['dt'];
    }

    /**
     * Return day after today.
     * 
     * @param date $date
     * @return date
     */
    public function dayAfter($date) {
        $date = Defaults::dateExplode($date);
        $date['dt'] ++;
        $date = Defaults::normalizeDate($date);

        return $date['yr'] . '-' . $date['mth'] . '-' . $date['dt'];
    }

    /**
     * 
     * @return boolean
     * TRUE: Recover loan after loan repayment period in the application.
     * FALSE: Recover loan after the stipulated repayment period for the loan type.
     */
    public function recoverLoanAfterLoanRepaymentPeriod() {
        return true;
    }

}
