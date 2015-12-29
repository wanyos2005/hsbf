<?php

/**
 * This is the model class for table "expenditures".
 *
 * The followings are the available columns in table 'expenditures':
 * @property integer $id
 * @property string $votehead
 * @property string $date
 * @property string $amount
 * @property integer $member
 * @property string $description
 * @property string $trans_channes
 * @property integer $associated_id
 * @property string $receipt_no
 * @property string $cask_or_bank
 * @property string $logged_in
 */
class Expenditures extends CActiveRecord {

    const LOAN_OUTWARD = 'Loan outward';
    const DEPOSIT_TO_BANK = 'Deposit to bank';
    const SAVINGS_WITHDRAWAL = 'Savings withdrawal';
    const LOANING_CHANNEL = 'LoanApplications'; //this is a model className
    const SAVING_WITHDRAWAL_CHANNEL = 'CashWithdrawals'; //this is a model className

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'expenditures';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('votehead, date, amount, description, receipt_no, cask_or_bank, logged_in', 'required'),
            array('member, logged_in, associated_id', 'numerical', 'integerOnly' => true),
            array('votehead, trans_channes', 'length', 'max' => 128),
            array('amount', 'numerical', 'min' => 0.001),
            array('amount, receipt_no', 'length', 'max' => 15),
            array('description', 'description'),
            array('description, cask_or_bank', 'length', 'min' => 3, 'max' => 40),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, votehead, date, amount, member, description, trans_channes, associated_id, receipt_no, cask_or_bank, logged_in', 'safe', 'on' => 'search'),
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
            'votehead' => 'Votehead',
            'date' => 'Date',
            'amount' => 'Amount',
            'member' => 'Member',
            'description' => 'Description',
            'trans_channes' => 'Transaction Type',
            'associated_id' => 'Associted Id',
            'receipt_no' => 'Receipt No',
            'cask_or_bank' => 'Cash/Bank',
            'logged_in' => 'Logged In'
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
        $criteria->compare('votehead', $this->votehead, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('member', $this->member);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('trans_channes', $this->trans_channes, true);
        $criteria->compare('associated_id', $this->associated_id);
        $criteria->compare('receipt_no', $this->receipt_no, true);
        $criteria->compare('cask_or_bank', $this->cask_or_bank, true);
        $criteria->compare('logged_in', $this->logged_in);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Expenditures the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param string $attribute name of attribute
     */
    public function description($attribute) {
        if (is_numeric($this->$attribute))
            $this->addError($attribute, 'Cannot be numeric');
    }

    /**
     * capture loan award as an expense
     * 
     * @param \LoanApplications $loanApplication model
     */
    public function loanApplicationIsExpense($loanApplication) {
        $expense = $this->find('trans_channes=:chnl && associated_id=:id', array(':chnl' => $className = get_class($loanApplication), ':id' => $loanApplication->primaryKey));

        $nextReceiptNo = false;
        if (empty($expense)) {
            $expense = new Expenditures;

            $expense->votehead = self::LOAN_OUTWARD;
            $expense->trans_channes = $className;
            $expense->associated_id = $loanApplication->id;
            $expense->receipt_no = NextReceiptNo::model()->receiptNo();
            $expense->member = $loanApplication->member;
            $expense->description = self::LOAN_OUTWARD;
            $expense->cask_or_bank = ContributionsByMembers::PAYMENT_BY_CASH;
            $expense->logged_in = Yii::app()->user->id;
            $expense->date = $loanApplication->close_date;

            $nextReceiptNo = true;
        }

        $expense->amount = $loanApplication->amout_borrowed;

        if ($expense->save(false) && $nextReceiptNo)
            NextReceiptNo::model()->updateNextReceiptNo($expense->receipt_no);
    }

    /**
     * 
     * @param \CashWithdrawals $savingWithdrawal model
     */
    public function cashWithdrawalIsExpense($savingWithdrawal) {
        $expense = $this->find('trans_channes=:chnl && associated_id=:id', array(':chnl' => $className = get_class($savingWithdrawal), ':id' => $savingWithdrawal->primaryKey));

        $nextReceiptNo = false;
        if (empty($expense)) {
            $expense = new Expenditures;

            $expense->votehead = self::SAVINGS_WITHDRAWAL;
            $expense->trans_channes = $className;
            $expense->associated_id = $savingWithdrawal->id;
            $expense->receipt_no = NextReceiptNo::model()->receiptNo();
            $expense->member = $savingWithdrawal->member;
            $expense->description = self::SAVINGS_WITHDRAWAL;
            $expense->cask_or_bank = $savingWithdrawal->cash_or_cheque == CashWithdrawals::WITHDRAWAL_BY_CHEQUE ?
                    ContributionsByMembers::PAYMENT_BY_BANK : ContributionsByMembers::PAYMENT_BY_CASH;
            $expense->logged_in = Yii::app()->user->id;
            $expense->date = $savingWithdrawal->treasurer_date;

            $nextReceiptNo = true;
        }

        $expense->amount = $savingWithdrawal->amount;

        if ($expense->save(false) && $nextReceiptNo)
            NextReceiptNo::model()->updateNextReceiptNo($expense->receipt_no);
    }

    /**
     * 
     * @param Incomes $income model
     */
    public function depositIntoBankIsExpense($income) {
        $expense = $this->find('trans_channes=:chnl && associated_id=:id', array(':chnl' => $className = get_class($income), ':id' => $income->primaryKey));

        $nextReceiptNo = false;
        if (empty($expense)) {
            $expense = new Expenditures;

            $expense->votehead = $income->votehead;
            $expense->trans_channes = $className;
            $expense->associated_id = $income->id;
            $expense->receipt_no = NextReceiptNo::model()->receiptNo();
            $expense->member = $income->member;
            $expense->description = $income->description;
            $expense->cask_or_bank = ContributionsByMembers::PAYMENT_BY_BANK;
            $expense->logged_in = Yii::app()->user->id;
            $expense->date = $income->date;

            $nextReceiptNo = true;
        }

        $expense->amount = $income->amount;

        if ($expense->save(false) && $nextReceiptNo)
            NextReceiptNo::model()->updateNextReceiptNo($expense->receipt_no);
    }

    /**
     * 
     * @param int $loanApplicationId loan application id
     * @param date $dateDue yyyy-mm-dd
     * @return double amount (to be) accumulated on a loan application
     */
    public function evaluateLoanApplicationAmountForStatement($loanApplicationId, $dateDue) {
        $loanApplication = LoanApplications::model()->returnALoanApplication($loanApplicationId);
        if (is_object($loanApplication)) {
            if (strtoupper($loanApplication->serviced) != 'YES')
                return LoanRepayments::model()->amountDue($loanApplication->amout_borrowed, $loanApplication->interest_rate, $loanApplication->close_date, $dateDue);

            return LoanRepayments::model()->totalRecoveries($this->repaymentsTowardsLoanByEndofDate($loanApplication->primaryKey, $dateDue));
        }
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return \Expenditures models
     */
    public function expendituresBetweenAndIncludingThisDates($since, $till) {
        $cri = new CDbCriteria;
        $cri->condition = 'date>=:dt && date<=:dt1';
        $cri->params = array(':dt' => $since, ':dt1' => $till);
        $cri->order = 'date ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $member person id
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return \Expenditures models
     */
    public function expendituresOnMemberBetweenAndIncludingThisDates($member, $since, $till) {
        $cri = new CDbCriteria;
        $cri->condition = '(trans_channes=:chnl1 || trans_channes=:chnl2) && date>=:dt && date<=:dt1 && member=:mbr';
        $cri->params = array(':chnl1' => self::LOANING_CHANNEL, ':chnl2' => self::SAVING_WITHDRAWAL_CHANNEL, ':dt' => $since, ':dt1' => $till, ':mbr' => $member);
        $cri->order = 'date ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @param string $cashOrBank Cash or Bank
     * @return \Expenditures models
     */
    public function cashOrBankExpendituresBetweenAndIncludingThisDates($since, $till, $cashOrBank) {
        $cri = new CDbCriteria;
        $cri->condition = 'date>=:dt && date<=:dt1 && cask_or_bank=:cob';
        $cri->params = array(':dt' => $since, ':dt1' => $till, ':cob' => $cashOrBank);
        $cri->order = 'date ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param type $member
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return array total expenditures
     */
    public function totalExpenditureOnMemberFromStartToIncludingThisDate($member, $since, $till) {
        $total = 0;
        $pendingLoanAmounts = 0;

        foreach ($this->expendituresOnMemberBetweenAndIncludingThisDates($member, '0000-00-00', $since) as $expenditure) {
            $total = $total + $expenditure->amount;

            if ($expenditure->trans_channes == Expenditures::LOANING_CHANNEL) {
                $loanValues = LoanRepayments::model()->profitEarnedOrToBeEarnedOnLoanBetweenAndIncludingTheseDates($expenditure->associated_id, $since);
                if (!empty($loanValues[LoanRepayments::INTEREST])) {
                    $total = $total + $loanValues[LoanRepayments::INTEREST];

                    if ($loanValues[LoanRepayments::REDUCING_BALANCE] > 0) {
                        $newLoanValues = LoanRepayments::model()->profitEarnedOrToBeEarnedOnLoanBetweenAndIncludingTheseDates($expenditure->associated_id, $till);
                        $paymentsWithinDates = LoanRepayments::model()->memberLoanRepaymentsBtwnDatesAgain($expenditure->associated_id, LoanApplications::model()->dayAfter($since), $till);

                        $pendingLoanAmounts = $pendingLoanAmounts + $newLoanValues[LoanRepayments::INTEREST] - (empty($paymentsWithinDates) ? $loanValues[LoanRepayments::INTEREST] : 0);
                    }
                }
            }
        }

        return array('total' => $total, 'pendingTotal' => $pendingLoanAmounts);
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @return double total expenditure
     */
    public function totalExpendituresFromStartToIncludingThisDate($date) {
        $total = 0;
        foreach ($this->expendituresBetweenAndIncludingThisDates('0000-00-00', $date) as $expenditure)
            $total = $total + $expenditure->amount;

        return $total;
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @param string $cashOrBank Cash or Bank
     * @return double total expenditure
     */
    public function totalCashOrBankExpendituresFromStartToIncludingThisDate($date, $cashOrBank) {
        $total = 0;
        foreach ($this->cashOrBankExpendituresBetweenAndIncludingThisDates('0000-00-00', $date, $cashOrBank) as $expenditure)
            $total = $total + $expenditure->amount;

        return $total;
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @return double net income at end of this day
     */
    public function netIncomeAfterYesterday($date) {
        return
                Incomes::model()->totalIncomesFromStartToIncludingThisDate(LoanApplications::model()->dayBefore($date)) - //just a line break
                $this->totalExpendituresFromStartToIncludingThisDate(LoanApplications::model()->dayBefore($date))
        ;
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @param string $cashOrBank Cash or Bank
     * @return double net income at end of this day
     */
    public function netCashOrBankIncomeAfterYesterday($date, $cashOrBank) {
        return
                Incomes::model()->totalCashOrBankIncomesFromStartToIncludingThisDate(LoanApplications::model()->dayBefore($date), $cashOrBank) - //just a line break
                $this->totalCashOrBankExpendituresFromStartToIncludingThisDate(LoanApplications::model()->dayBefore($date), $cashOrBank)
        ;
    }

    /**
     * 
     * @param int $member person id
     * @param date $date yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return double net income at end of this day
     */
    public function netMembersIncomeAfterYesterday($member, $date, $till) {
        return
                array(
                    'income' => Incomes::model()->totalIncomeFromMemberFromStartToIncludingThisDate($member, LoanApplications::model()->dayBefore($date), $till),
                    'expenditure' => $this->totalExpenditureOnMemberFromStartToIncludingThisDate($member, LoanApplications::model()->dayBefore($date), $till)
                )
        ;
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function printExpenditureJournal($since, $till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Payment Expenditure Journal', 'application.views.pdf.expenseJournal', array(
            'expenses' => $this->expendituresBetweenAndIncludingThisDates($since, $till), 'since' => $since, 'till' => $till
                ), 'Payment Expenditure Journal'
        );
    }

    /**
     * 
     * @param Incomes | Expenditures $tranctions
     * @param date $date yyyy-mm-dd
     * @return array amounts
     */
    public function dailyBatchTransactions($tranctions, $date) {
        foreach ($tranctions as $tranction)
            if ($tranction->date == $date)
                if (!isset($dailyTransactions[$tranction->description]))
                    $dailyTransactions[$tranction->description] = $tranction->amount;
                else
                    $dailyTransactions[$tranction->description] = $dailyTransactions[$tranction->description] + $tranction->amount;

        return empty($dailyTransactions) ? array() : $dailyTransactions;
    }

}
