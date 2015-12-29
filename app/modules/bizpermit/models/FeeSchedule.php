<?php


class FeeSchedule extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_fee_schedule';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('schedule_name', 'required'),
                    array('schedule_description', 'required'),
                    array('brims_code', 'required'),
                    array('sbp_fee', 'safe')
                    
                );
        }

        public function primaryKey()
        {
                return 'schedule_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
