<?php

/**
 * This is the model class for table "dependent_members".
 *
 * The followings are the available columns in table 'dependent_members':
 * @property integer $id
 * @property integer $principal_member
 * @property string $name
 * @property string $dob
 * @property string $idno
 * @property string $alive
 * @property string $relationship
 * @property string $mobileno
 * @property string $postaladdress
 */
class DependentMembers extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dependent_members';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('principal_member, name, alive, relationship', 'required'),
            array('principal_member, mobileno', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'min' => 7, 'max' => 30),
            array('dob', 'length', 'is' => 10),
            array('idno', 'length', 'min' => 7, 'max' => 8),
            array('idno', 'numerical', 'min' => 1),
            array('alive', 'length', 'max' => 1),
            array('relationship, mobileno', 'length', 'max' => 20),
            array('postaladdress', 'length', 'min' => 7, 'max' => 50),
            array('relationship', 'relationship'),
            array('name, postaladdress', 'name'),
            array('mobileno', 'mobile'),
            array('idno, mobileno', 'uniqueAttribute'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, principal_member, name, dob, idno, alive, relationship, mobileno, postaladdress', 'safe', 'on' => 'search'),
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
            'principal_member' => 'Principal Member',
            'name' => 'Name',
            'dob' => 'Date of Birth',
            'idno' => 'Nat. ID. No.',
            'alive' => 'Alive',
            'relationship' => 'Relationship',
            'mobileno' => 'Mobile No.',
            'postaladdress' => 'Postal Address',
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
        $criteria->compare('principal_member', $this->principal_member);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('dob', $this->dob, true);
        $criteria->compare('idno', $this->idno, true);
        $criteria->compare('alive', $this->alive, true);
        $criteria->compare('relationship', $this->relationship, true);
        $criteria->compare('mobileno', $this->mobileno, true);
        $criteria->compare('postaladdress', $this->postaladdress, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDependent($principal_member, $first, $second) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        // $criteria->compare('id', $this->id);
         //$criteria->compare('principal_member', $principal_member);
        // $criteria->compare('name', $this->name, true);
        // $criteria->compare('dob', $this->dob, true);
        // $criteria->compare('idno', $this->idno, true);
        // $criteria->compare('alive', $this->alive, true);
        // $criteria->compare('relationship', $second);
        // $criteria->compare('mobileno', $this->mobileno, true);
        // $criteria->compare('postaladdress', $this->postaladdress, true);
        $criteria->condition = "principal_member=:mbr && (relationship=:fst || relationship=:scd)";
        $criteria->params = array(':mbr' => $principal_member, ':fst' => $first, ':scd' => $second);
        $criteria->order = 'name ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DependentMembers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relationship($attribute) {
        if ($this->$attribute == 4 || $this->$attribute == 9) {
            if (empty($this->idno))
                $this->addError('idno', $this->getAttributeLabel('idno') . ' is required');
            if (empty($this->mobileno))
                $this->addError('mobileno', $this->getAttributeLabel('mobileno') . ' is required');
            if (empty($this->postaladdress))
                $this->addError('postaladdress', $this->getAttributeLabel('postaladdress') . ' is required');
        } else
        if ($this->$attribute == 5 || $this->$attribute == 10) {
            if (empty($this->dob))
                $this->addError('dob', $this->getAttributeLabel('dob') . ' is required');
        }
    }

    public function uniqueAttribute($attribute) {
        if (!empty($this->$attribute)) {
            $get1 = DependentMembers::model()->find($this->isNewRecord ? "$attribute=:attr" : "$attribute=:attr && id!=:id", $params = $this->isNewRecord ? array(':attr' => $this->$attribute) : array(':attr' => $this->$attribute, ':id' => $this->primaryKey));
            $get1 = DependentMembers::model()->find($this->isNewRecord ? "$attribute=:attr" : "$attribute=:attr && id!=:id", $params = $this->isNewRecord ? array(':attr' => $this->$attribute) : array(':attr' => $this->$attribute, ':id' => $this->primaryKey));
            if (!empty($get1))
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ' already exists');
        }
    }

    public function name($attribute) {
        if (is_numeric($this->$attribute))
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' cannot be numeric!');
    }

    public function mobile($attribute) {
        if (!empty($this->$attribute))
            if (!is_numeric($this->$attribute) or $this->$attribute < 0) {
                $this->addError($attribute, 'Mobile No. must be a positive integer');
            } else
            if (strlen($this->$attribute) < 9 || strlen($this->$attribute) > 12)
                $this->addError($attribute, 'Mobile No.: 9 to 12 digits!');
            else {
                $pattern1 = '/^7(\d{8})$/';
                $pattern2 = '/^07(\d{8})$/';
                $pattern3 = '/^2547(\d{8})$/';
                if (!preg_match($pattern1, $this->$attribute) && !preg_match($pattern2, $this->$attribute) && !preg_match($pattern3, $this->$attribute))
                    $this->addError($attribute, 'Mobile No.: 7xxxxxxxx or 07xxxxxxxx or 254xxxxxxxx without symbols');
            }
    }

    /**
     * 
     * @param int $member Member
     * @param int $rltn1 Relationship
     * @param int $rltn2 Relationship
     * @return \DependentMembers Dependent members of member.
     */
    public function returnDependentsOfMember($member, $rltn1, $rltn2) {
        $cri = new CDbCriteria;
        $cri->condition = "principal_member=:mbr && (relationship=:rltn1 || relationship=:rltn2)";
        $cri->params = array(':mbr' => $member, ':rltn1' => $rltn1, ':rltn2' => $rltn2);
        $cri->order = 'relationship ASC, name ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param int $principalmember Member
     * @param int $relationship Relationship
     * @return boolean
     * TRUE: Member has dependent member with the relationship.
     * FALSE: Member has not dependent member with the relationship.
     */
    public function dependents($principalmember, $relationship) {
        $cri = new CDbCriteria;
        $cri->condition = 'principal_member=:id && relationship=:rltn';
        $cri->params = array(':id' => $principalmember, ':rltn' => $relationship);

        if (count($this->find($cri)) > 0)
            return true;

        return false;
    }

}
