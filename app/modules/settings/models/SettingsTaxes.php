<?php

/**
 * This is the model class for table "settings_taxes".
 *
 * The followings are the available columns in table 'settings_taxes':
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $rate
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property InventoryStockTaxes[] $inventoryStockTaxes
 * @property SettingsTaxCategory $category
 */
class SettingsTaxes extends ActiveRecord implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_taxes';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('category_id, name, rate', 'required'),
                    array('category_id', 'numerical', 'integerOnly' => true),
                    array('name', 'length', 'max' => 60),
                    array('rate', 'length', 'max' => 10),
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
                    'inventoryStockTaxes' => array(self::HAS_MANY, 'InventoryStockTaxes', 'tax_id'),
                    'category' => array(self::BELONGS_TO, 'SettingsTaxCategory', 'category_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'category_id' => Lang::t('Category'),
                    'name' => Lang::t('Tax'),
                    'rate' => Lang::t('Rate'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsTaxes the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'category_id',
                    'id',
                );
        }

}
