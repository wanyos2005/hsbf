<?php

/**
 * This is the model class for table "registration_and_monthly_contribution_amounts".
 *
 * The followings are the available columns in table 'registration_and_monthly_contribution_amounts':
 * @property integer $id
 * @property integer $contribution_type
 * @property string $amount
 */
class RegistrationAndMonthlyContributionAmounts extends CActiveRecord {
    
    const MINIMUM_AMOUNT = 100;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'registration_and_monthly_contribution_amounts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('contribution_type, amount', 'required'),
            array('contribution_type, amount', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical', 'min' => $min = self::MINIMUM_AMOUNT, 'message' => "Minimum amount acceptable is $min"),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, contribution_type, amount', 'safe', 'on' => 'search'),
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
        $criteria->compare('contribution_type', $this->contribution_type);
        $criteria->compare('amount', $this->amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegistrationAndMonthlyContributionAmounts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 
     * @param int $contributionType contribution type id
     * @return \RegistrationAndMonthlyContributionAmounts model
     */
    public function returnAmountModel($contributionType) {
        $amount = $this->find('contribution_type=:type', array(':type' => $contributionType));
        
        if (!empty($amount))
            return $amount;
        
        $amount = new RegistrationAndMonthlyContributionAmounts;
        $amount->contribution_type = $contributionType;
        $amount->amount = self::MINIMUM_AMOUNT;
        $amount->save(false);
        
        return $amount;
    }
    
    /**
     * 
     * @param int $contributionType contribution type id
     * @return double amount
     */
    public function amount($contributionType) {
        $amount = $this->returnAmountModel($contributionType);
        return $amount->amount;
    }
    
    

}
