<?php

/**
 * This is the model class for table "person_address".
 *
 * The followings are the available columns in table 'person_address':
 * @property string $id
 * @property string $person_id
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property string $address
 * @property string $residence
 * @property string $address2
 * @property string $residence2
 * @property string $date_created
 * @property integer $created_by
 * @property string $last_modified
 *
 * The followings are the available model relations:
 * @property Person $person
 */
class PersonAddress extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'person_address';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('person_id, phone1', 'required', 'message' => Lang::t('Phone number is required')),
            array('created_by', 'numerical', 'integerOnly' => true),
            array('person_id', 'length', 'max' => 11),
            array('phone1, phone2', 'length', 'max' => 15),
            array('email', 'length', 'max' => 128),
            array('address, residence, address2, residence2', 'length', 'max' => 255),
            array('email', 'email', 'message' => Lang::t('Please enter a valid email address.')),
            array('last_modified', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Lang::t('ID'),
            'phone1' => Lang::t('Phone 1'),
            'phone2' => Lang::t('Phone 2'),
            'email' => Lang::t('Email'),
            'address' => Lang::t('Present Address'),
            'residence' => Lang::t('Present Residence'),
            'address2' => Lang::t('Permanent Address'),
            'residence2' => Lang::t('Permanent Residence'),
            'date_created' => Lang::t('Date Created'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PersonAddress the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param int $person_id person id
     * @return \PersonAddress model
     */
    public function addressForPerson($person_id) {
        return $this->find('person_id=:person', array(':person' => $person_id));
    }

}
