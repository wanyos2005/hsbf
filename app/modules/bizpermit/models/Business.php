<?php


class Business extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_business';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('business_name', 'required'),
                    array('longitude', 'required'),
                    array('latitude', 'required')
                    
                );
        }

        public function primaryKey()
        {
                return 'business_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
