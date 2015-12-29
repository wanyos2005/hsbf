<?php


class councilSchedule extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_council_schedule';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('schedule_no', 'required')
                    
                );
        }

        public function primaryKey()
        {
                return 'cl_schedule_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
