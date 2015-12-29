<?php


class ScheduleCategory extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_schedule_category';
        }

       /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('category_code', 'required'),
                    array('category_name', 'required'),
                    array('category_description', 'required')
                    
                );
        }

        public function primaryKey()
        {
                return 'category_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
