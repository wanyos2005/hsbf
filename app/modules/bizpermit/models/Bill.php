<?php


class Bill extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_bill';
        }

        public function relations() {
        return array('business' => array(self::BELONGS_TO, 'Business', 'bill_business_id'),'bill_item' => array(self::HAS_MANY, 'BillItem', 'bill_item_ref'));
        }

        public function primaryKey()
        {
                return 'bill_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
