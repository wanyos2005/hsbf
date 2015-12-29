<?php


class penaltyRate extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_penalty_rate';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('rate', 'required')              
                    
                );
        }

        public function primaryKey()
        {
                return 'penalty_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
