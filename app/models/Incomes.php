<?php

/**
 * This is the model class for table "incomes".
 *
 * The followings are the available columns in table 'incomes':
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
class Incomes extends CActiveRecord {

    const CONTRIBUTION_BY_MEMBER = 'Contribution by member';
    const INCOME_BY_CONTRIBUTION = 'ContributionsByMembers'; //this is a model className
    const INCOME_BY_LOAN_REPAYMENT = 'LoanRepayments'; //this is a model className
    const INCOME_BY_CASH_SAVING = 'Savings'; //this is a model className
    const WITHDRAWAL_FROM_BANK = 'Withdrawal from bank'; //from bank
    const CASH_ACCOUNT = 'Cash Account';
    const BANK_ACCOUNT = 'Bank Account';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'incomes';
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
     * 
     * @return array payment in/out by cash or bank
     */
    public static function toBankOrCash() {
        $options = ContributionsByMembers::model()->paymentModes();
        unset($options[ContributionsByMembers::PAYMENT_BY_MPESA]);
        return $options;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Incomes the static model class
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
     * capture a contribution as income
     * 
     * @param \ContributionsByMembers $contribution model
     */
    public function contributionIsIncome($contribution) {
        $income = $this->find('receipt_no=:rcpt', array(':rcpt' => $contribution->receiptno));

        if (empty($income)) {
            $income = new Incomes;
            $income->votehead = self::CONTRIBUTION_BY_MEMBER;
            $income->trans_channes = get_class($contribution);
            $income->associated_id = $contribution->id;
            $income->receipt_no = $contribution->receiptno;
            $income->member = $contribution->member;
            $income->description = self::CONTRIBUTION_BY_MEMBER;
            $income->cask_or_bank = $contribution->payment_mode == ContributionsByMembers::PAYMENT_BY_CASH ?
                    ContributionsByMembers::PAYMENT_BY_CASH : ContributionsByMembers::PAYMENT_BY_BANK;
            $income->logged_in = Yii::app()->user->id;
            $income->date = $contribution->date;
        }

        $income->amount = 0;

        foreach ($contribution->findAll('receiptno=:rcpt', array(':rcpt' => $contribution->receiptno)) as $amount)
            $income->amount = $income->amount + $amount->amount;

        $income->save(false);
    }

    /**
     * 
     * @param Expenditures $expense model
     */
    public function withdrawalFromBankIsIncome($expense) {
        $income = $this->find('trans_channes=:chnl && associated_id=:id', array(':chnl' => $className = get_class($expense), ':id' => $expense->primaryKey));

        $nextReceiptNo = false;
        if (empty($income)) {
            $income = new Incomes;

            $income->votehead = $expense->votehead;
            $income->trans_channes = $className;
            $income->associated_id = $expense->id;
            $income->receipt_no = NextReceiptNo::model()->receiptNo();
            $income->member = $expense->member;
            $income->description = $expense->description;
            $income->cask_or_bank = ContributionsByMembers::PAYMENT_BY_BANK;
            $income->logged_in = Yii::app()->user->id;
            $income->date = $expense->date;

            $nextReceiptNo = true;
        }

        $income->amount = $expense->amount;

        if ($income->save(false) && $nextReceiptNo)
            NextReceiptNo::model()->updateNextReceiptNo($income->receipt_no);
    }

    /**
     * 
     * @param int $savingId saving id
     * @param date $dateDue yyyy-mm-dd
     * @return double amount (to be) accumulated on a loan application
     */
    public function evaluateSavingsAmountForStatement($savingId, $dateDue) {
        $saving = Savings::model()->findByPk($savingId);
        if (is_object($saving)) {
            if (Savings::model()->savingIsWithdrawableByThisDate($savingId, $dateDue))
                return Savings::model()->totalWithDrawals(Savings::model()->withdrawalsfromASavingBetweenAndIncludingTheseDates($savingId, '0000-00-00', $dateDue));

            return LoanRepayments::model()->amountDue($saving->principal, $saving->interest_rate_per_annum, $saving->date_of_investment, $dateDue, 0);
        }
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return \Incomes models
     */
    public function incomesBetweenAndIncludingThisDates($since, $till) {
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
     * @return \Incomes models
     */
    public function incomesFromMemberBetweenAndIncludingThisDates($member, $since, $till) {
        $cri = new CDbCriteria;
        $cri->condition = '(trans_channes=:chnl1 || trans_channes=:chnl2 || trans_channes=:chnl3) && date>=:dt && date<=:dt1 && member=:mbr';
        $cri->params = array(':chnl1' => self::INCOME_BY_CONTRIBUTION, ':chnl2' => self::INCOME_BY_LOAN_REPAYMENT, ':chnl3' => self::INCOME_BY_CASH_SAVING, ':dt' => $since, ':dt1' => $till, ':mbr' => $member);
        $cri->order = 'date ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @param string $cashOrBank Cash or Bank
     * @return \Incomes models
     */
    public function cashOrBankIncomesBetweenAndIncludingThisDates($since, $till, $cashOrBank) {
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
     * @return array total incomes
     */
    public function totalIncomeFromMemberFromStartToIncludingThisDate($member, $since, $till) {
        $total = 0;
        $pendingSavings = 0;

        foreach ($this->incomesFromMemberBetweenAndIncludingThisDates($member, '0000-00-00', $since) as $income) {
            $total = $total + $income->amount;

            if ($income->trans_channes == self::INCOME_BY_CONTRIBUTION || $income->trans_channes == self::INCOME_BY_CASH_SAVING) {
                $savingValues = Savings::model()->profitEarnedOrToBeEarnedOnSavingBetweenAndIncludingTheseDates(
                        $savingId = $income->trans_channes == self::INCOME_BY_CONTRIBUTION ? ContributionsByMembers::model()->savingIdForContribution($income->associated_id) : $income->associated_id, '0000-00-00', $since
                );

                if (!empty($savingValues[Savings::INTEREST])) {
                    $total = $total + $savingValues[Savings::INTEREST];

                    if ($savingValues[Savings::REDUCING_BALANCE] > 0) {
                        $newSavingValues = Savings::model()->profitEarnedOrToBeEarnedOnSavingBetweenAndIncludingTheseDates($savingId, '0000-00-00', $till);

                        $latestSavingHistory = Savings::model()->latestSavingHistoryBetweenAndIncludingTheseDates($savingId, LoanApplications::model()->dayAfter($since), $till);

                        $pendingSavings = $pendingSavings + $newSavingValues[Savings::INTEREST] - (empty($latestSavingHistory) ? $savingValues[Savings::INTEREST] : 0);
                    }
                }
            }
        }
        return array('total' => $total, 'pendingSaving' => $pendingSavings);
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @return double total income
     */
    public function totalIncomesFromStartToIncludingThisDate($date) {
        $total = 0;
        foreach ($this->incomesBetweenAndIncludingThisDates('0000-00-00', $date) as $income)
            $total = $total + $income->amount;

        return $total;
    }

    /**
     * 
     * @param date $date yyyy-mm-dd
     * @param string $cashOrBank Cash or Bank
     * @return double total income
     */
    public function totalCashOrBankIncomesFromStartToIncludingThisDate($date, $cashOrBank) {
        $total = 0;
        foreach ($this->cashOrBankIncomesBetweenAndIncludingThisDates('0000-00-00', $date, $cashOrBank) as $income)
            $total = $total + $income->amount;

        return $total;
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function incomeJournal($since, $till) {
        $expenses = $this->incomesBetweenAndIncludingThisDates($since, $till);
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function printIncomeJournal($since, $till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Payment Income Journal', 'application.views.pdf.incomeJournal', array(
            'incomes' => $this->incomesBetweenAndIncludingThisDates($since, $till), 'since' => $since, 'till' => $till
                ), 'Payment Income Journal'
        );
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function printCashBook($since, $till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'CashBook', 'application.views.pdf.cashBook', array(
            'incomes' => $incomes = $this->incomesBetweenAndIncludingThisDates($since, $till),
            'expenditures' => $expenditures = Expenditures::model()->expendituresBetweenAndIncludingThisDates($since, $till),
            'months' => $this->associatedMonths($dates = $this->extractDates($incomes, $expenditures)),
            'dates' => $this->orderDates($dates, $since, $till),
            'since' => $since, 'till' => $till
                ), 'CashBook'
        );
    }

    /**
     * 
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function printBalanceSheet($since, $till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Balance Sheet', 'application.views.pdf.balanceSheet', array(
            'incomes' => $incomes = $this->incomesBetweenAndIncludingThisDates($since, $till),
            'expenditures' => $expenditures = Expenditures::model()->expendituresBetweenAndIncludingThisDates($since, $till),
            'months' => $this->associatedMonths($dates = $this->extractDates($incomes, $expenditures)),
            'dates' => $this->orderDates($dates, $since, $till),
            'since' => $since, 'till' => $till
                ), 'Balance Sheet'
        );
    }

    /**
     * 
     * @param int | string $member member id, bank or cash
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     */
    public function printLedgerBook($member, $since, $till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Ledger Book', 'application.views.pdf.ledgerBook', array(
            'incomes' => $incomes = $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ?
            $this->cashOrBankIncomesBetweenAndIncludingThisDates($since, $till, $member) : $this->incomesFromMemberBetweenAndIncludingThisDates($member, $since, $till),
            'expenditures' => $expenditures = $member == ContributionsByMembers::PAYMENT_BY_CASH || $member == ContributionsByMembers::PAYMENT_BY_BANK ?
            Expenditures::model()->cashOrBankExpendituresBetweenAndIncludingThisDates($since, $till, $member) : Expenditures::model()->expendituresOnMemberBetweenAndIncludingThisDates($member, $since, $till),
            'months' => $this->associatedMonths($dates = $this->extractDates($incomes, $expenditures)),
            'dates' => $this->orderDates($dates, $since, $till),
            'since' => $since, 'till' => $till, 'member' => $member
                ), 'Ledger Book'
        );
    }

    /**
     * 
     * @param date $till yyyy-mm-dd
     */
    public function printTrialBalance($till) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Trial Balance', 'application.views.pdf.trialBalance', array(
            'rows' => $this->balancesForMembers($this->cashAndBankBalances(array(), LoanApplications::model()->dayAfter($till)), Person::model()->membersForTrialBalance(), LoanApplications::model()->dayAfter($till), $till), 'till' => $till
                ), 'Trial Balance'
        );
    }

    /**
     * 
     * @param array $dates dates
     * @param date $since
     * @param date $till
     * @return array ordered dates
     */
    public function orderDates($dates, $since, $till) {
        if ($since > $till) {
            $mid = $till;
            $till = $since;
            $since = $mid;
        }

        while ($since <= $till) {
            if (isset($dates[$since]))
                if (!isset($oderedDates[$since]))
                    $oderedDates[$since] = '';
            $since = LoanApplications::model()->dayAfter($since);
        }

        return empty($oderedDates) ? array() : $oderedDates;
    }

    /**
     * 
     * @param array $dates dates
     * @return array months yyyy-mm
     */
    public function associatedMonths($dates) {
        foreach ($dates as $date => $null)
            if (!isset($months[substr($date, 0, 7)]))
                $months[substr($date, 0, 7)] = '';

        return empty($months) ? array() : $months;
    }

    /**
     * 
     * @param Incomes $incomes models
     * @param Expenditures $expenditures models
     * @return array dates
     */
    public function extractDates($incomes, $expenditures) {
        foreach ($incomes as $income)
            if (!isset($dates[$income->date]))
                $dates[$income->date] = '';

        foreach ($expenditures as $expenditure)
            if (!isset($dates[$expenditure->date]))
                $dates[$expenditure->date] = '';

        return empty($dates) ? array() : $dates;
    }

    /**
     * 
     * @param Incomes|Expenditures $incomes models
     * @return array receipt numbers
     */
    public function extractReceiptNos($incomes) {
        foreach ($incomes as $income)
            if (!isset($receipts[$income->votehead]))
                $receipts[$income->votehead] = '';

        return empty($receipts) ? array() : $receipts;
    }

    /**
     * 
     * @param array $balanceRows rows for trial balance
     * @param date $till yyyy-mm-dd
     * @return array rows for trial balance
     */
    public function cashAndBankBalances($balanceRows, $till) {
        $cashBalance = Expenditures::model()->netCashOrBankIncomeAfterYesterday(LoanApplications::model()->dayAfter($till), ContributionsByMembers::PAYMENT_BY_CASH);
        $bankBalance = Expenditures::model()->netCashOrBankIncomeAfterYesterday(LoanApplications::model()->dayAfter($till), ContributionsByMembers::PAYMENT_BY_BANK);

        if ($cashBalance > 0) {
            $balanceRows[ContributionsByMembers::PAYMENT_BY_CASH]['name'] = ContributionsByMembers::PAYMENT_BY_CASH;
            $balanceRows[ContributionsByMembers::PAYMENT_BY_CASH]['credit'] = $cashBalance < 0 ? $cashBalance : null;
            $balanceRows[ContributionsByMembers::PAYMENT_BY_CASH]['debit'] = $cashBalance > 0  ? abs($cashBalance) : null;
        }
        
        if ($bankBalance > 0) {
            $balanceRows[ContributionsByMembers::PAYMENT_BY_BANK]['name'] = ContributionsByMembers::PAYMENT_BY_BANK;
            $balanceRows[ContributionsByMembers::PAYMENT_BY_BANK]['credit'] = $bankBalance > 0 ? abs($bankBalance) : null;
            $balanceRows[ContributionsByMembers::PAYMENT_BY_BANK]['debit'] = $bankBalance < 0  ? $bankBalance : null;
        }

        return $balanceRows;
    }

    /**
     * 
     * @param array $balanceRows rows for trial balance
     * @param Person $members models
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return array rows for trial balance
     */
    public function balancesForMembers($balanceRows, $members, $since, $till) {
        foreach ($members as $member) {
            $balance = Expenditures::model()->netMembersIncomeAfterYesterday($member->id, $since, LoanApplications::model()->dayAfter($till));
            $netIncomes = $netExpenditures = $balance['income']['total'] - $balance['expenditure']['total'];
            
            if ($netIncomes > 0) {
                $netExpenditures = null;
            } else {
                $netExpenditures = abs($netExpenditures);
                $netIncomes = null;
            }

            if ($netExpenditures + $netIncomes > 0) {
                $balanceRows[$member->id]['name'] = "$member->first_name $member->middle_name $member->last_name";
                $balanceRows[$member->id]['credit'] = empty($netIncomes) ? null : $netIncomes;
                $balanceRows[$member->id]['debit'] = empty($netExpenditures) ? null : $netExpenditures;
            }
        }
        
        return $balanceRows;
    }

}
