<?php

/**
 * This is the model class for table "dept".
 *
 * The followings are the available columns in table 'dept':
 * @property string $id
 * @property string $name
 * @property string $telephone1
 * @property string $telephone2
 * @property string $email
 * @property string $address
 * @property string $contact_person_id
 * @property string $status
 * @property string $country_id
 * @property string $location
 * @property string $latitude
 * @property string $longitude
 * @property string $date_created
 * @property string $created_by
 * @property string $last_modified
 * @property string $last_modified_by
 *
 * The followings are the available model relations:
 * @property Person $contactPerson
 * @property SettingsCountry $country
 * @property DeptUser[] $deptUsers
 */
class Dept extends ActiveRecord implements IMyActiveSearch {

        const STATUS_OPEN = 'Open';
        const STATUS_CLOSED = 'Closed';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'dept';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('name, email, location', 'length', 'max' => 128),
                    array('telephone1, telephone2', 'length', 'max' => 15),
                    array('address', 'length', 'max' => 255),
                    array('contact_person_id, country_id, created_by, last_modified_by', 'length', 'max' => 11),
                    array('status', 'length', 'max' => 6),
                    array('latitude, longitude', 'length', 'max' => 30),
                    array('last_modified', 'safe'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'contactPerson' => array(self::BELONGS_TO, 'Person', 'contact_person_id'),
                    'country' => array(self::BELONGS_TO, 'SettingsCountry', 'country_id'),
                    'deptUsers' => array(self::HAS_MANY, 'DeptUser', 'dept_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Name'),
                    'telephone1' => Lang::t('Telephone 1'),
                    'telephone2' => Lang::t('Telephone 2'),
                    'email' => Lang::t('Email'),
                    'address' => Lang::t('Postal address'),
                    'contact_person_id' => Lang::t('Contact Person'),
                    'status' => Lang::t('Status'),
                    'country_id' => Lang::t('Country'),
                    'location' => Lang::t('Location'),
                    'latitude' => Lang::t('Latitude'),
                    'longitude' => Lang::t('Longitude'),
                    'date_created' => Lang::t('Date Created'),
                    'created_by' => Lang::t('Created By'),
                    'last_modified' => Lang::t('Last Modified'),
                    'last_modified_by' => Lang::t('Last Modified By'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return Dept the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'contact_person_id',
                    'country_id',
                    'id',
                );
        }

        /**
         * Get statuses
         * @return type
         */
        public static function statusOptions()
        {
                return array(
                    self::STATUS_OPEN => Lang::t(self::STATUS_OPEN),
                    self::STATUS_CLOSED => Lang::t(self::STATUS_CLOSED),
                );
        }

        /**
         * Update contact person of a dept
         * @param type $dept_id
         * @param type $person_id
         * @return type
         */
        public function updateContactPerson($dept_id, $person_id)
        {
                if (!empty($dept_id)) {
                        Yii::app()->db->createCommand()
                                ->update($this->tableName(), array('contact_person_id' => $person_id), '`id`=:t1 AND `contact_person_id` IS NULL', array(':t1' => $dept_id));
                } else {
                        Yii::app()->db->createCommand()
                                ->update($this->tableName(), array('contact_person_id' => NULL), '`contact_person_id`=:t1', array(':t1' => $person_id));
                }
        }

}
