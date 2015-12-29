<?php

/**
 * This is the model class for table "user_activity".
 *
 * The followings are the available columns in table 'user_activity':
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $description
 * @property string $ip_address
 * @property string $datetime
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserActivity extends ActiveRecord {

        const TYPE_LOGIN = 'login';
        const TYPE_CREATE = 'create';
        const TYPE_UPDATE = 'update';
        const TYPE_DELETE = 'delete';

        /**
         * Do not record activity for this model
         * @var type
         */
        public $logAuditTrail = false;

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'user_activity';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('id, user_id, type, ip_address, datetime,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'user_id' => Lang::t('User'),
                    'type' => Lang::t('Type'),
                    'description' => Lang::t('Description'),
                    'ip_addres' => Lang::t('IP Address'),
                    'datetime' => Lang::t('Time'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('datetime', self::SEARCH_FIELD, true),
                    'user_id',
                    'type',
                    'ip_address',
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return UserActivity the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * Add activity
         * @param integer $user_id
         * @param string $type
         * @param string $description
         */
        public function addActivity($user_id, $type, $description)
        {
                return Yii::app()->db->createCommand()
                                ->insert($this->tableName(), array(
                                    'user_id' => $user_id,
                                    'type' => $type,
                                    'description' => $description,
                                    'ip_address' => Common::getIp(),
                                    'datetime' => new CDbExpression('NOW()'),
                ));
        }

}
