<?php

/**
 * This is the model class for table "cash_withdrawals".
 *
 * The followings are the available columns in table 'cash_withdrawals':
 * @property integer $id
 * @property string $member
 * @property string $cash_or_cheque
 * @property string $cheque_no
 * @property string $amount
 * @property string $date
 * @property string $received_by_secretary
 * @property string $secretary_date
 * @property string $approved_by_chairman
 * @property string $chairman_date
 * @property string $effected_by_treasurer
 * @property string $treasurer_date
 */
class CashWithdrawals extends CActiveRecord {

    /**
     * Withdrawal in cash or cheque
     */
    const WITHDRAWAL_IN_CASH = 'Cash';
    const WITHDRAWAL_BY_CHEQUE = 'Cheque';

    /**
     * Approvals
     */
    const YES = 'Yes';
    const NO = 'No';
    const PENDING = 'Pending';
    const INSTEAD_OF_RECEIPT = 'Withdrawal';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cash_withdrawals';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member, cash_or_cheque, amount, date', 'required'),
            array('member, cheque_no, amount', 'length', 'max' => 11),
            array('amount', 'numerical', 'min' => 0.001, 'message' => 'Amount too small!'),
            array('amount', 'availableSavings'),
            array('cash_or_cheque', 'length', 'max' => 6),
            array('received_by_secretary, approved_by_chairman, effected_by_treasurer', 'length', 'max' => 7),
            array('secretary_date, chairman_date, treasurer_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member, cash_or_cheque, cheque_no, amount, date, received_by_secretary, secretary_date, approved_by_chairman, chairman_date, effected_by_treasurer, treasurer_date', 'safe', 'on' => 'search'),
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
            'cash_or_cheque' => 'Cash Or Cheque',
            'cheque_no' => 'Cheque No',
            'amount' => 'Amount',
            'date' => 'Date',
            'received_by_secretary' => 'Received By Secretary',
            'secretary_date' => 'Secretary Date',
            'approved_by_chairman' => 'Approved By Chairman',
            'chairman_date' => 'Chairman Date',
            'effected_by_treasurer' => 'Effected By Treasurer',
            'treasurer_date' => 'Treasurer Date',
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
        $criteria->compare('member', $this->member, true);
        $criteria->compare('cash_or_cheque', $this->cash_or_cheque, true);
        $criteria->compare('cheque_no', $this->cheque_no, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('received_by_secretary', $this->received_by_secretary, true);
        $criteria->compare('secretary_date', $this->secretary_date, true);
        $criteria->compare('approved_by_chairman', $this->approved_by_chairman, true);
        $criteria->compare('chairman_date', $this->chairman_date, true);
        $criteria->compare('effected_by_treasurer', $this->effected_by_treasurer, true);
        $criteria->compare('treasurer_date', $this->treasurer_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CashWithdrawals the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Date when withdrawer submits request for withdrawal.
     * 
     * @param \CashWithdrawals $withdrawal Model
     */
    public function dateThis($withdrawal) {
        if ($withdrawal->isNewRecord)
            $withdrawal->date = date('Y') . '-' . date('m') . '-' . date('d');
        else {
            $model = $this->returnAWithdrawal($withdrawal->primaryKey);

            if ($withdrawal->cash_or_cheque != $model->cash_or_cheque || $withdrawal->amount != $model->amount)
                $withdrawal->date = date('Y') . '-' . date('m') . '-' . date('d');
        }

        if (empty($withdrawal->cash_or_cheque) || empty($withdrawal->amount))
            $withdrawal->date = null;
    }

    public function availableSavings($attribute) {
        $netSavings = $this->availableSavingsAsAtThisDate($this->member, $this->date);
        if ($this->$attribute > $netSavings)
            $this->addError($attribute, "Availbale Savings: KShs. $netSavings");
    }

    /**
     * 
     * @param int $withdrawer Member.
     * @param date $asAtThisDay By end of this date.
     * @return double Savings less Withdrawals
     */
    public function availableSavingsAsAtThisDate($withdrawer, $asAtThisDay) {
        $savings = floor(
                Savings::model()->membersAvailableSavingsAsAtThisDate($withdrawer, empty($asAtThisDay) ? date('Y') . '-' . date('m') . '-' . date('d') : $asAtThisDay)
                //ContributionsByMembers::model()->totalMemberContribution($withdrawer, 3, empty($asAtThisDay) ? date('Y') . '-' . date('m') . '-' . date('d') : $asAtThisDay)
        );

        if (empty($savings))
            return '0';

        return $savings;
    }

    /**
     * 
     * @param in $withdrawer Member withdrawing savings.
     * @param date $asAtThisDay By end of this date.
     * @return double Total withdrawals.
     */
    public function totalCashWithdrawalsByMemberAsAtThisDate($withdrawer, $asAtThisDay) {
        $total = $this->computeTotalWithdrawals($this->cashWithdrawalsByMemberAsAtThisDate($withdrawer, $asAtThisDay));

        return "$total";
    }

    /**
     * 
     * @param \CashWithdrawals $withdrawals models
     * @return double Description
     */
    public function computeTotalWithdrawals($withdrawals) {
        $total = 0;

        foreach (empty($withdrawals) ? array() : $withdrawals as $withdrawal)
            $total = $total + $withdrawal->amount;

        return empty($total) ? '0' : $total;
    }

    /**
     * 
     * @param int $withdrawer Member withdrawing savings.
     * @param date $asAtThisDay By end of this date.
     * @return \CashWithdrawals Withdarawals so far.
     */
    public function cashWithdrawalsByMemberAsAtThisDate($withdrawer, $asAtThisDay) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && treasurer_date IS NOT NULL && treasurer_date<=:dt && effected_by_treasurer='Yes'";
        $cri->params = array(':mbr' => $withdrawer, ':dt' => $asAtThisDay);
        $cri->order = 'treasurer_date DESC, id DESC';

        return $this->model()->findAll($cri);
    }

    /**
     * 
     * @param int $withdrawer Member withdrawing savings.
     * @param date $startDate Beginning from this date.
     * @param date $asAtThisDay By end of this date.
     * @return \CashWithdrawals Withdarawals so far.
     */
    public function cashWithdrawalsByMemberBtwnDates($withdrawer, $startDate, $asAtThisDay) {
        $cri = new CDbCriteria;
        $cri->condition = "member=:mbr && treasurer_date IS NOT NULL && treasurer_date>=:dt && treasurer_date<=:dt1 && effected_by_treasurer='Yes'";
        $cri->params = array(':mbr' => $withdrawer, ':dt' => $startDate, ':dt1' => $asAtThisDay);
        $cri->order = 'treasurer_date ASC, id ASC';

        return $this->model()->findAll($cri);
    }

    /**
     * 
     * @param id $pk
     * @return \CashWithdrawals
     */
    public function returnAWithdrawal($pk) {
        return CashWithdrawals::model()->findByPk($pk);
    }

    /**
     * 
     * @return array Forms of withdrawals.
     */
    public function cashOrCheque() {
        return array(
            self::WITHDRAWAL_IN_CASH => self::WITHDRAWAL_IN_CASH,
            self::WITHDRAWAL_BY_CHEQUE => self::WITHDRAWAL_BY_CHEQUE
        );
    }

    /**
     * 
     * @return array Approve
     */
    public function approveOrOtherwise() {
        return array(
            self::YES => self::YES,
            self::NO => self::NO,
            self::PENDING => self::PENDING
        );
    }

}
