<?php

/**
 * This is the model class for table "savings".
 *
 * The followings are the available columns in table 'savings':
 * @property integer $id
 * @property integer $member
 * @property integer $savings_id
 * @property string $principal
 * @property string $interest_rate_per_annum
 * @property string $date_of_investment
 * @property string $can_be_withdrawn
 * @property string $earliest_withdrawal_date
 * @property string $date_of_withdrawal
 * @property string $accumulated_amount
 * @property string $amount_withdrawn
 * @property string $balance
 */
class Savings extends CActiveRecord {

    /**
     * can or not be withdrawn
     */
    const WITHDRAWABLE_YES = 'yes';
    const WITHDRAWABLE_NO = 'no';
    const MINIMUM_HOLDING_MONTHS = 6;
    const INSTEAD_OF_RECEIPT = null;
    const INTEREST_RATE = 'Interest Rate';
    const STYLE = 'styles';
    const PRINCIPAL = 'principal';
    const AMOUNT_WITHDRAWN = 'amount_withdrawan';
    const REDUCING_BALANCE = 'saving_balance';
    const ACCUMULATED_SAVING = 'total_saving';
    const INTEREST = 'interest';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'savings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member, savings_id, principal, interest_rate_per_annum, date_of_investment, can_be_withdrawn, earliest_withdrawal_date', 'required'),
            array('member, savings_id', 'numerical', 'integerOnly' => true),
            array('principal, accumulated_amount, amount_withdrawn, balance', 'length', 'max' => 11),
            array('interest_rate_per_annum', 'length', 'max' => 5),
            array('can_be_withdrawn', 'length', 'max' => 3),
            array('date_of_withdrawal', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member, savings_id, principal, interest_rate_per_annum, date_of_investment, can_be_withdrawn, earliest_withdrawal_date, date_of_withdrawal, accumulated_amount, amount_withdrawn, balance', 'safe', 'on' => 'search'),
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
            'member' => 'Person Id',
            'savings_id' => 'Savings Id',
            'principal' => 'Principal',
            'interest_rate_per_annum' => 'Interest Rate Per Annum',
            'date_of_investment' => 'Date Of Investment',
            'can_be_withdrawn' => 'Can Be Withdrawn',
            'earliest_withdrawal_date' => 'Earliest Withdrawal Date',
            'date_of_withdrawal' => 'Date Of Withdrawal',
            'accumulated_amount' => 'Accumulated Amount',
            'amount_withdrawn' => 'Cash Withdrawals Id',
            'balance' => 'Balance',
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
        $criteria->compare('savings_id', $this->savings_id);
        $criteria->compare('principal', $this->principal, true);
        $criteria->compare('interest_rate_per_annum', $this->interest_rate_per_annum, true);
        $criteria->compare('date_of_investment', $this->date_of_investment, true);
        $criteria->compare('can_be_withdrawn', $this->can_be_withdrawn, true);
        $criteria->compare('earliest_withdrawal_date', $this->earliest_withdrawal_date, true);
        $criteria->compare('date_of_withdrawal', $this->date_of_withdrawal, true);
        $criteria->compare('accumulated_amount', $this->accumulated_amount, true);
        $criteria->compare('amount_withdrawn', $this->amount_withdrawn, true);
        $criteria->compare('balance', $this->balance, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Savings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param \ContributionsByMembers $contribution model
     */
    public function contributionToSavings($contribution) {
        $saving = new Savings;
        $saving->member = $contribution->member;
        $saving->savings_id = $contribution->primaryKey;
        $saving->principal = $contribution->amount;
        $saving->interest_rate_per_annum = $contribution->savings_interest;
        $saving->date_of_investment = $contribution->date;
        $saving->can_be_withdrawn = self::WITHDRAWABLE_YES;
        $saving->earliest_withdrawal_date = $this->earliestWithrawalDate($saving->date_of_investment, self::MINIMUM_HOLDING_MONTHS);

        $saving->save(false);
    }

    /**
     * 
     * @param int $saving_id contribution by member id or savings saving_id
     * @param date $date yyyy-mm-dd
     * @return boolean true - could be withdrawn
     */
    public function savingIsWithdrawableByThisDate($saving_id, $date) {
        $model = $this->find('savings_id=:svng && date_of_investment<=:dt && can_be_withdrawn=:wthdrw', array(
            ':svng' => $saving_id, ':dt' => LoanApplications::model()->dayAfter($date), ':wthdrw' => self::WITHDRAWABLE_YES
                )
        );

        return is_object($model);
    }

    /**
     * 
     * @param int $saving_id contribution by member id or savings saving_id
     * @param date $startDate yyyy-mm-dd
     * @param date $endDate yyyy-mm-dd
     * @return \Savings models
     */
    public function withdrawalsfromASavingBetweenAndIncludingTheseDates($saving_id, $startDate, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'savings_id=:svng && date_of_investment>=:dt1 && date_of_investment<=:dt2';
        $cri->params = array(':svng' => $saving_id, ':dt1' => $startDate, ':dt2' => $endDate);
        $cri->order = 'date_of_investment ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param \CashWithdrawals $cashWithdrawal model
     */
    public function cashWithdrawaltoSavings($cashWithdrawal) {
        $amountToBeWithdrawn = $cashWithdrawal->amount;

        if (empty($newSaving)) {
            foreach ($this->membersSavingsAsAtThisDate($cashWithdrawal->member, $cashWithdrawal->date) as $saving)
                if ($amountToBeWithdrawn > 0)
                    if ($this->canBeWithdrawn($saving)) {
                        $accumulatedAmount = LoanRepayments::model()->amountDue($saving->principal, $saving->interest_rate_per_annum, $saving->date_of_investment, $cashWithdrawal->date, 0);
                        $saving->date_of_withdrawal = $cashWithdrawal->date;
                        $saving->accumulated_amount = $accumulatedAmount;
                        $saving->amount_withdrawn = $cashWithdrawal->primaryKey;

                        $reducingAmountToBeWithdrawn = $accumulatedAmount >= $amountToBeWithdrawn ? $amountToBeWithdrawn : $amountToBeWithdrawn - $saving->accumulated_amount;

                        $amountToBeWithdrawn = $amountToBeWithdrawn - $reducingAmountToBeWithdrawn;

                        $saving->balance = $saving->accumulated_amount - $reducingAmountToBeWithdrawn;

                        $saving->can_be_withdrawn = self::WITHDRAWABLE_NO;

                        $saving->save(false);

                        if ($saving->balance > 0) {
                            $newSaving = new Savings;
                            $newSaving->member = $saving->member;
                            $newSaving->savings_id = $saving->savings_id;
                            $newSaving->principal = $saving->balance;
                            $newSaving->interest_rate_per_annum = ContributionsByMembers::SAVINGS_INTEREST;
                            $newSaving->date_of_investment = $cashWithdrawal->date;
                            $newSaving->can_be_withdrawn = self::WITHDRAWABLE_YES;
                            $newSaving->earliest_withdrawal_date = $newSaving->date_of_investment;
                            $newSaving->save(false);
                        }
                    }
        }
    }

    /**
     * 
     * @param int $member person id
     * @param date $endDate yyyy-mm-dd
     * @return \Savings models
     */
    public function membersSavingsAsAtThisDate($member, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && date_of_investment<=:endDt';
        $cri->params = array(':mbr' => $member, ':endDt' => $endDate);
        $cri->order = 'savings_id ASC, date_of_investment ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $member person id
     * @param date $endDate yyyy-mm-dd
     * @return \Savings models
     */
    public function membersSavingsForStatement($member, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && date_of_investment<=:endDt';
        $cri->params = array(':mbr' => $member, ':endDt' => $endDate);
        $cri->order = 'date_of_investment ASC, id ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $member person id
     * @param date $endDate yyyy-mm-dd
     * @return double member's available savings
     */
    public function membersAvailableSavingsAsAtThisDate($member, $endDate) {
        $amount = 0;

        foreach ($this->membersSavingsAsAtThisDate($member, $endDate) as $saving)
            if ($this->canBeWithdrawn($saving))
                $amount = $amount + LoanRepayments::model()->amountDue($saving->principal, $saving->interest_rate_per_annum, $saving->date_of_investment, $endDate, 0);

        return $amount;
    }

    /**
     * 
     * @param \Savings $savings open savings
     * @param date $endDate yyyy-mm-dd
     * @return double total savings 
     */
    public function computeTotalForOpenInvestments($savings, $endDate) {
        $total = 0;

        foreach ($savings as $saving)
            $total = $total + LoanRepayments::model()->amountDue($saving->principal, $saving->interest_rate_per_annum, $saving->date_of_investment, $endDate, 0);

        return round($total, 3);
    }

    /**
     * 
     * @param \Savings $savings open savings
     * @return double total 
     */
    public function totalAccumulatedAmounts($savings) {
        $total = 0;

        foreach ($savings as $saving)
            $total = $total + $saving->accumulated_amount;

        return round($total, 3);
    }

    /**
     * 
     * @param \Savings $savings open savings
     * @return double total 
     */
    public function totalDeposits($savings) {
        $total = 0;

        foreach ($savings as $saving)
            $total = $total + $saving->principal;

        return round($total, 3);
    }

    /**
     * 
     * @param \Savings $savings savings
     * @return double total 
     */
    public function totalWithDrawals($savings) {
        $total = 0;

        foreach ($savings as $saving)
            $total = $total + ($saving->accumulated_amount - $saving->balance);

        return round($total, 3);
    }

    /**
     * 
     * @param date $dateOfInvestment yyyy-mm-dd
     * @param int $minimumMonths duration in  months
     * @return date yyyy-mm-dd
     */
    public function earliestWithrawalDate($dateOfInvestment, $minimumMonths) {
        $splitDate = Defaults::dateExplode($dateOfInvestment);
        $splitDate['mth'] = $splitDate['mth'] + $minimumMonths;

        if ($splitDate['mth'] > 12) {
            $splitDate['yr'] ++;
            $splitDate['mth'] = $splitDate['mth'] - 12;
        }

        if ($splitDate['dt'] > ($maxDate = Defaults::maxdate($splitDate['mth'], $splitDate['yr'])))
            $splitDate['dt'] = $maxDate;

        return $splitDate['yr'] . '-' . Defaults::twoDigits($splitDate['mth']) . '-' . Defaults::twoDigits($splitDate['dt']);
    }

    /**
     * 
     * @param int $member person id
     * @return boolean true - member can withdraw savings
     */
    public function memberCanWithraw($member) {
        $possibleWithdrawal = $this->find(
                'member=:mbr && principal>0 && can_be_withdrawn=:check && earliest_withdrawal_date<=:endDt', //
                array(
            ':mbr' => $member, ':check' => self::WITHDRAWABLE_YES, ':endDt' => date('Y') . '-' . date('m') . '-' . date('d')
                )
        );

        return !empty($possibleWithdrawal);
    }

    /**
     * 
     * @param \Savings $saving model
     * @return boolean true - can be withdrawn, part or whole
     */
    public function canBeWithdrawn($saving) {
        return $saving->principal > 0 && $saving->can_be_withdrawn == self::WITHDRAWABLE_YES && $saving->earliest_withdrawal_date <= date('Y') . '-' . date('m') . '-' . date('d');
    }

    /**
     * 
     * @param int $contribution_id contribution by members id
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return Savings models
     */
    public function latestSavingHistoryBetweenAndIncludingTheseDates($contribution_id, $since, $till) {
        $cri = new CDbCriteria;
        $cri->condition = 'savings_id=:svng && date_of_investment>=:dt1 && date_of_investment<=:dt2';
        $cri->params = array(':svng' => $contribution_id, ':dt1' => $since, ':dt2' => $till);
        $cri->order = 'date_of_investment DESC, id DESC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $savingId Savings id
     * @param date $since yyyy-mm-dd
     * @param date $till yyyy-mm-dd
     * @return array saving values
     */
    public function profitEarnedOrToBeEarnedOnSavingBetweenAndIncludingTheseDates($savingId, $since, $till) {
        if (is_object($saving = $this->findByPk($savingId)))
            return array(
                self::PRINCIPAL => $saving->principal,
                self::AMOUNT_WITHDRAWN => $accumulatedSaving = $this->totalWithDrawals($latestSavingHistory = $this->latestSavingHistoryBetweenAndIncludingTheseDates($saving->savings_id, $since, $till)),
                self::REDUCING_BALANCE => $remainingSaving = isset($latestSavingHistory[0]) && $latestSavingHistory[0]->principal > 0 && empty($latestSavingHistory[0]->accumulated_amount) ?
                LoanRepayments::model()->amountDue($latestSavingHistory[0]->principal, $latestSavingHistory[0]->interest_rate_per_annum, $latestSavingHistory[0]->date_of_investment, $till, 0) : 0,
                self::ACCUMULATED_SAVING => $accumulatedSaving = $accumulatedSaving + $remainingSaving,
                self::INTEREST => round($accumulatedSaving - $saving->principal, 2)
            );

        return array();
    }

}
