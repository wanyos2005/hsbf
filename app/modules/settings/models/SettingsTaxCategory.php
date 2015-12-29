<?php

/**
 * This is the model class for table "settings_tax_category".
 *
 * The followings are the available columns in table 'settings_tax_category':
 * @property integer $id
 * @property string $name
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property SettingsTaxes[] $settingsTaxes
 */
class SettingsTaxCategory extends ActiveRecord implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_tax_category';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('name', 'length', 'max' => 60),
                    array('name', 'unique', 'message' => '{value} already exists.'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'settingsTaxes' => array(self::HAS_MANY, 'SettingsTaxes', 'category_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Category'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsTaxCategory the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'id',
                );
        }

}
