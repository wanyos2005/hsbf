<?php

/**
 * This is the model class for table "relationships".
 *
 * The followings are the available columns in table 'relationships':
 * @property integer $id
 * @property string $gender
 * @property string $relationship
 */
class Relationships extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'relationships';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gender, relationship', 'required'),
            array('gender', 'length', 'max' => 1),
            array('relationship', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gender, relationship', 'safe', 'on' => 'search'),
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
            'gender' => 'Gender',
            'relationship' => 'Relationship',
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
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('relationship', $this->relationship, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Relationships the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function returnRelationships($gdr) {
        return Relationships::model()->findAll('gender=:gdr', array(':gdr' => $gdr));
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function returnRelationship($id) {
        $model = Relationships::model()->findByPk($id);
        return empty($model) ? null : $model->relationship;
    }

    /**
     * 
     * @param string $id relationship id
     * @return string relation
     */
    public function relationshipOrKinOrNominee($id) {
        $rltn = $id == 1 || 6 ? 'Parents' : (
                $id = 2 || 7 ? 'Parents-in-Law' : (
                $id = 3 || 8 ? 'Siblings' : (
                $id = 4 || 9 ? 'Spouse' : (
                $id = 5 || 10 ? ' Children' :
                null))));

        if (empty($rltn))
            $rltn = KinsAndNominees::model()->kinOrNominee($id);
        
        return $rltn;
    }

}
