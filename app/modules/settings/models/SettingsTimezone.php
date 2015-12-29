<?php

/**
 * This is the model class for table "settings_timezone".
 *
 * The followings are the available columns in table 'settings_timezone':
 * @property integer $id
 * @property string $name
 */
class SettingsTimezone extends ActiveRecord {

        const DEFAULT_TIME_ZONE = 'Africa/Nairobi';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_timezone';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {

                return array(
                    array('name', 'required'),
                    array('name', 'length', 'max' => 255),
                    array('name', 'unique', 'message' => '{value} already exists.'),
                    array('id, name', 'safe', 'on' => 'search'),
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
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsTimezone the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

}
