<?php

/**
 * This is the model class for table "loans".
 *
 * The followings are the available columns in table 'loans':
 * @property integer $id
 * @property string $loan_type
 * @property string $value_type
 * @property string $available
 * @property string $interest_rate
 * @property string $repayment_period
 * @property integer $deduct_form_payroll
 * @property integer $one_third
 */
class Loans extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'loans';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('loan_type, value_type, available, interest_rate, repayment_period', 'required'),
            array('deduct_form_payroll, one_third', 'numerical', 'integerOnly' => true),
            array('loan_type', 'length', 'max' => 40),
            array('value_type', 'length', 'max' => 7),
            array('available', 'length', 'max' => 20),
            array('interest_rate, repayment_period', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, loan_type, value_type, available, interest_rate, repayment_period, deduct_form_payroll, one_third', 'safe', 'on' => 'search'),
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
            'loan_type' => 'Loan Type',
            'value_type' => 'Value Type',
            'available' => 'Available',
            'interest_rate' => 'Interest Rate',
            'repayment_period' => 'Repayment Period',
            'deduct_form_payroll' => 'Deduct Form Payroll',
            'one_third' => 'One Third',
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
        $criteria->compare('loan_type', $this->loan_type, true);
        $criteria->compare('value_type', $this->value_type, true);
        $criteria->compare('available', $this->available, true);
        $criteria->compare('interest_rate', $this->interest_rate, true);
        $criteria->compare('repayment_period', $this->repayment_period, true);
        $criteria->compare('deduct_form_payroll', $this->deduct_form_payroll);
        $criteria->compare('one_third', $this->one_third);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Loans the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return loan model
     * 
     * @param int $loantype
     * @return \Loans
     */
    public function defaultLoanParameters($loantype) {
        return Loans::model()->findByPk($loantype);
    }

    /**
     * Determine available loan a member can borrow up to
     * 
     * @param type $loan
     * @param type $totalContributions
     * @return type
     */
    public function availableLoan($loan, $totalContributions) {
        if ($loan->value_type == 'Amount')
            return $loan->available;

        if ($loan->value_type == 'Percent')
            return $loan->available / 100 * $totalContributions;
    }

    /**
     * Check whether one third rule applies effectively.
     * 
     * @param double $monthlyRepaymentAmount
     * @param boolean $one_third
     * @param double $basicPay
     * @return boolean
     */
    public function oneThirdRule($monthlyRepaymentAmount, $one_third, $basicPay) {
        if ($one_third == 0 || $basicPay * 2 / 3 > $monthlyRepaymentAmount)
            return false; //one-third rule not effected

        return true; //one-third rule effected
    }
    
    /**
     * Retuen a required loan type
     * 
     * @param int $pk
     * @return \Loans
     */
    public function returnARequiredLoan($pk) {
        return Loans::model()->findByPk($pk);
    }

}
