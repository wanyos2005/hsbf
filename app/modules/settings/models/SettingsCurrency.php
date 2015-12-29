<?php

/**
 * This is the model class for table "settings_currency".
 *
 * The followings are the available columns in table 'settings_currency':
 * @property string $id
 * @property string $symbol
 * @property string $date_created
 * @property integer $created_by
 */
class SettingsCurrency extends ActiveRecord {

        const CURRENCY_KES = 'KES';
        const CURRENCY_USD = 'USD';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_currency';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('id', 'required'),
                    array('created_by', 'numerical', 'integerOnly' => true),
                    array('id', 'length', 'max' => 60),
                    array('symbol', 'length', 'max' => 30),
                    array(self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
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
                    'id' => 'Currency',
                    'symbol' => 'Symbol',
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsCurrency the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * Get currency symbol
         * @param type $id
         * @return type
         */
        public function getSymbol($id)
        {
                $symbol = $this->get($id, 'symbol');
                return !empty($symbol) ? $symbol : $id;
        }

        /**
         * Format money
         * @param type $currency
         * @param type $amount
         * @param type $decimals
         * @param type $symbol
         */
        public function formatMoney($currency, $amount, $decimals = 2, $symbol = true)
        {
                $amount = number_format($amount, $decimals);
                if ($symbol)
                        $currency = $this->getSymbol($currency);
                return CHtml::decode($currency . $amount);
        }

}
