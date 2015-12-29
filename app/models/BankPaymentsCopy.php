<?php

/**
 * This is the model class for table "bank_payments_copy".
 *
 * The followings are the available columns in table 'bank_payments_copy':
 * @property integer $id
 * @property string $idno
 * @property string $date
 * @property integer $contribution_type
 * @property string $amount
 */
class BankPaymentsCopy extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bank_payments_copy';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idno, date, contribution_type, amount', 'required'),
            array('contribution_type', 'length', 'max' => 2),
            array('idno', 'length', 'max' => 10),
            array('amount', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, idno, date, contribution_type, amount', 'safe', 'on' => 'search'),
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
            'idno' => 'Idno',
            'date' => 'Date',
            'contribution_type' => 'Contribution Type',
            'amount' => 'Amount',
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
        $criteria->compare('idno', $this->idno, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('contribution_type', $this->contribution_type, true);
        $criteria->compare('amount', $this->amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BankPaymentsCopy the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param \Person $person model
     * @return \BankPaymentsCopy models
     */
    public function bankPaymentByMember($person) {
        return $this->findAll('idno=:idno', array(':idno' => $person->idno));
    }

    /**
     * 
     * @return \BankPaymentsCopy models
     */
    public function allBankPaymentCopies() {
        return $this->findAll(array('order' => 'id ASC'));
    }

    /**
     * 
     * @return int no of payments made through bank
     */
    public function countAllBankPaymentCopies() {
        return count($this->allBankPaymentCopies());
    }

}
