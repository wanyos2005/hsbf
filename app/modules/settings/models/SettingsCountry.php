<?php

/**
 * This is the model class for table "settings_country".
 *
 * The followings are the available columns in table 'settings_country':
 * @property integer $id
 * @property string $name
 * @property string $country_code
 * @property string $date_created
 */
class SettingsCountry extends ActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_country';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('name', 'length', 'max' => 128),
                    array('country_code', 'length', 'max' => 4),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => 'ID',
                    'name' => 'Name',
                    'country_code' => 'Country Code',
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsCountry the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

}
