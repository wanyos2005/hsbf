<?php


class Payment extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'bpt_payment';
        }

       /* public function relations() {
        return array('bill' => array(self::BELONGS_TO, 'Bill', 'bill_item_ref'));
        }*/

        public function rules()
        {
                return array(
                    array('payment_amount', 'required'),
                    array('payment_bill_reference', 'required')
                   
                    
                );
        }

        public function primaryKey()
        {
                return 'payment_id';
        }

        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }       

}
