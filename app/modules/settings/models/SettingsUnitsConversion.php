<?php

/**
 * This is the model class for table "settings_units_conversion".
 *
 * The followings are the available columns in table 'settings_units_conversion':
 * @property integer $id
 * @property integer $from_unit_id
 * @property integer $to_unit_id
 * @property double $value
 * @property string $date_created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property SettingsUnitsOfMeasure $toUnit
 * @property SettingsUnitsOfMeasure $fromUnit
 */
class SettingsUnitsConversion extends ActiveRecord implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_units_conversion';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('from_unit_id, to_unit_id, value', 'required'),
                    array('from_unit_id, to_unit_id, created_by', 'numerical', 'integerOnly' => true),
                    array('value', 'numerical'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'toUnit' => array(self::BELONGS_TO, 'SettingsUnitsOfMeasure', 'to_unit_id'),
                    'fromUnit' => array(self::BELONGS_TO, 'SettingsUnitsOfMeasure', 'from_unit_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'from_unit_id' => Lang::t('From'),
                    'to_unit_id' => Lang::t('To'),
                    'value' => Lang::t('Value'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsUnitsConversion the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    'id',
                    'from_unit_id',
                    'to_unit_id',
                    'value',
                );
        }

        /**
         *
         * @param type $from_unit_id
         * @param type $to_unit_id
         * @return array
         */
        public function getToLists($from_unit_id, $to_unit_id = null)
        {
                $result = array();
                //ID not equal to from_unit_id,
                $data = SettingsUnitsOfMeasure::model()->getData('id,name', '`id`<>:t1', array(':t1' => $from_unit_id), 'name');

                //remove all rows that exist in settings_units_conversion table
                foreach ($data as $row) {
                        if (!$this->exists('`from_unit_id`=:t1 AND `to_unit_id`=:t2', array(':t1' => $from_unit_id, ':t2' => $row['id'])))
                                array_push($result, $row);
                        else if ($row['id'] === $to_unit_id)
                                array_push($result, $row);
                }

                return $result;
        }

}
