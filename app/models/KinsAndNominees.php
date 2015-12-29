<?php

/**
 * This is the model class for table "kins_and_nominees".
 *
 * The followings are the available columns in table 'kins_and_nominees':
 * @property integer $id
 * @property integer $dependent_member
 * @property string $kinOrNominee
 * @property string $percent
 * @property string $active
 */
class KinsAndNominees extends CActiveRecord {

    /**
     * Next of kin or Nominee
     */
    const NEXT_OF_KIN = 'Next Of Kin';
    const NOMINEE = 'Nominee';

    /**
     * Kin Or Nominee still active or not
     */
    const ACTIVE = 'Yes';
    const INACTIVE = 'No';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kins_and_nominees';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dependent_member, kinOrNominee, active', 'required'),
            array('dependent_member', 'numerical', 'integerOnly' => true),
            array('kinOrNominee', 'length', 'max' => 11),
            array('percent', 'numerical', 'min' => 0, 'max' => 100),
            array('percent', 'length', 'max' => 5),
            array('percent', 'percent'),
            array('active', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, dependent_member, kinOrNominee, percent, active', 'safe', 'on' => 'search'),
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
            'dependent_member' => 'Dependent Member',
            'kinOrNominee' => 'Kin Or Nominee',
            'percent' => 'Percent',
            'active' => 'Active',
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
        $criteria->compare('dependent_member', $this->dependent_member);
        $criteria->compare('kinOrNominee', $this->kinOrNominee, true);
        $criteria->compare('percent', $this->percent, true);
        $criteria->compare('active', $this->active, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return KinsAndNominees the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param real $attribute Percent
     */
    public function percent($attribute) {
        if ($this->kinOrNominee == self::NOMINEE && $this->active == self::ACTIVE)
            if (empty($this->$attribute))
                $this->addError($attribute, "$attribute is required");
            else
            if (KinsAndNomineesController::percentagesUpto100() == true)
                $this->addError($attribute, "Percentages must not exceed 100%");
    }

    /**
     * 
     * @param int $member Member
     * @return \KinsAndNominees Next Of Kins.
     */
    public function nextOfKinsOfAMember($member) {
        $kins = array();

        for ($rltnshp = 1; $rltnshp <= 5; $rltnshp++)
            $kins[$rltnshp] = $this->dependentMembersAreKinsOrNominees(DependentMembers::model()->returnDependentsOfMember($member, $rltnshp, $rltnshp + 5), self::NEXT_OF_KIN);

        return $kins;
    }

    /**
     * 
     * @param int $member Member
     * @return \KinsAndNominees Nominees.
     */
    public function nomineesOfAMember($member) {
        $kins = array();

        for ($rltnshp = 1; $rltnshp <= 5; $rltnshp++)
            $kins[$rltnshp] = $this->dependentMembersAreKinsOrNominees(DependentMembers::model()->returnDependentsOfMember($member, $rltnshp, $rltnshp + 5), self::NOMINEE);

        return $kins;
    }

    /**
     * 
     * @param \KinsAndNominees Next of kins or Nominees
     * @return \KinsAndNominees Next of kins or Nominees
     */
    public function kinsOrNominees($kinsOrNominees) {
        $newKinsOrNominees = array();
        foreach ($kinsOrNominees as $rltnshps)
            foreach ($rltnshps as $kinOrNominee)
                $newKinsOrNominees[count($newKinsOrNominees)] = $kinOrNominee;

        return $newKinsOrNominees;
    }

    /**
     * 
     * @param \DependentMembers $dependents Possible kins or nominees.
     * @param string $kinsOrNominees Next of kin or Nominee.
     * @return \KinsAndNominees \KinsAndNominees models.
     */
    public function dependentMembersAreKinsOrNominees($dependents, $kinsOrNominees) {
        $kins = array();

        foreach ($dependents as $dependent) {
            $kinOrNominee = $this->find('dependent_member=:mbr && kinOrNominee=:kin && active=:act', array(
                ':mbr' => $dependent->primaryKey, ':kin' => $kinsOrNominees, ':act' => self::ACTIVE
                    )
            );

            if (!empty($kinOrNominee))
                $kins[$kinOrNominee->primaryKey] = $kinOrNominee;
        }

        return $kins;
    }

    /**
     * Save \KinsAndNominees conditionally.
     * @param \KinsAndNominees $model models.
     */
    public function modelSave($model) {
        if ($model->isNewRecord && ($model->active != self::ACTIVE || ($model->kinOrNominee == self::NOMINEE && empty($model->percent))))
            ; //do not save
        else
            $model->save();
    }

    public function kinOrNominee($kiNom) {
        switch ($kiNom) {
            case 'kin':
                return self::NEXT_OF_KIN . 's';
                break;

            case 'nom':
                return self::NOMINEE . 's';
                break;

            default:
                break;
        }
    }

}
