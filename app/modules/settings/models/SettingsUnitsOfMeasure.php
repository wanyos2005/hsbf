<?php

/**
 * This is the model class for table "settings_units_of_measure".
 *
 * The followings are the available columns in table 'settings_units_of_measure':
 * @property integer $id
 * @property string $name
 * @property string $date_created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property InventoryStock[] $inventoryStock
 * @property InventoryStock[] $inventoryStock1
 * @property SettingsUnitsConversion[] $settingsUnitsConversions
 * @property SettingsUnitsConversion[] $settingsUnitsConversions1
 */
class SettingsUnitsOfMeasure extends ActiveRecord implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_units_of_measure';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('created_by', 'numerical', 'integerOnly' => true),
                    array('name', 'length', 'max' => 128),
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
                    'inventoryStock' => array(self::HAS_MANY, 'InventoryStock', 'buying_units_of_measure_id'),
                    'inventoryStock1' => array(self::HAS_MANY, 'InventoryStock', 'selling_units_of_measure_id'),
                    'settingsUnitsConversions' => array(self::HAS_MANY, 'SettingsUnitsConversion', 'from_unit_id'),
                    'settingsUnitsConversions1' => array(self::HAS_MANY, 'SettingsUnitsConversion', 'to_unit_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Unit'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsUnitsOfMeasure the static model class
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
