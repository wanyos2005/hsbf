<?php


class Ward extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_ward';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('ward_name', 'required')
                    
                );
        }

        public function primaryKey()
        {
                return 'ward_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
