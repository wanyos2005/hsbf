<?php


class BillItem extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_bill_item';
        }

       /* public function relations() {
        return array('bill' => array(self::BELONGS_TO, 'Bill', 'bill_item_ref'));
        }*/

        public function primaryKey()
        {
                return 'bill_item_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
