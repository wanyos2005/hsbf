<?php

/**
 * This is the model class for table "member_withdrawal".
 *
 * The followings are the available columns in table 'member_withdrawal':
 * @property integer $id
 * @property integer $member
 * @property string $status
 * @property string $forwarded_by_secretary
 * @property string $forwarded_by_treasurer
 * @property string $approved_by_chairman
 * @property string $secretary_date
 * @property string $treasurer_date
 * @property string $chairman_date
 */
class MemberWithdrawal extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'member_withdrawal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member, status', 'required'),
            array('member', 'numerical', 'integerOnly' => true),
            array('status, forwarded_by_secretary, forwarded_by_treasurer, approved_by_chairman', 'length', 'max' => 7),
            array('secretary_date, treasurer_date, chairman_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member, status, forwarded_by_secretary, forwarded_by_treasurer, approved_by_chairman, secretary_date, treasurer_date, chairman_date', 'safe', 'on' => 'search'),
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
            'member' => 'Member',
            'status' => 'Status',
            'forwarded_by_secretary' => 'Forwarded By Secretary',
            'forwarded_by_treasurer' => 'Forwarded By Treasurer',
            'approved_by_chairman' => 'Approved By Chairman',
            'secretary_date' => 'Secretary Date',
            'treasurer_date' => 'Treasurer Date',
            'chairman_date' => 'Chairman Date',
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
        $criteria->compare('status', $this->status, true);
        $criteria->compare('forwarded_by_secretary', $this->forwarded_by_secretary, true);
        $criteria->compare('forwarded_by_treasurer', $this->forwarded_by_treasurer, true);
        $criteria->compare('approved_by_chairman', $this->approved_by_chairman, true);
        $criteria->compare('secretary_date', $this->secretary_date, true);
        $criteria->compare('treasurer_date', $this->treasurer_date, true);
        $criteria->compare('chairman_date', $this->chairman_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MemberWithdrawal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Return member withdrawal
     * 
     * @param type $member
     * @return type
     */
    public function member($member) {
        return MemberWithdrawal::model()->find('member=:mbr', array(':mbr' => $member));
    }

    /**
     * If member is active or otherwise
     * 
     * @param type $member
     * @return boolean
     */
    public function memberIsActive($member) {
        $member = $this->member($member);

        if (empty($member) || $member->status != 'No')
            return true;
    }

}
