<?php


class Zone extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_zone';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('zone_name', 'required')
                    
                );
        }

        public function primaryKey()
        {
                return 'zone_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
