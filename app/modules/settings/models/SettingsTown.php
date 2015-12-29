<?php

/**
 * This is the model class for table "settings_town".
 *
 * The followings are the available columns in table 'settings_town':
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property string $date_created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property SettingsCountry $country
 */
class SettingsTown extends ActiveRecord implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_town';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name, country_id', 'required'),
                    array('country_id, created_by', 'numerical', 'integerOnly' => true),
                    array('name', 'length', 'max' => 60),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'country' => array(self::BELONGS_TO, 'SettingsCountry', 'country_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Town'),
                    'country_id' => Lang::t('Country'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsTown the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'country_id',
                    'id',
                );
        }

}
