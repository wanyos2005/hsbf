<?php

/**
 * This is the model class for table "settings_email_template".
 *
 * The followings are the available columns in table 'settings_email_template':
 * @property integer $id
 * @property string $key
 * @property string $description
 * @property string $subject
 * @property string $body
 * @property string $from
 * @property string $comments
 * @property string $date_created
 * @property integer $created_by
 */
class SettingsEmailTemplate extends ActiveRecord implements IMyActiveSearch {
        //email template keys

        const KEY_FORGOT_PASSWORD = 'forgot_password';
        const KEY_RESET_PASSWORD = 'admin_reset_password';
        const KEY_NEW_USER = 'new_user';
        const KEY_ACCOUNT_ACTIVATION = 'account_activation';

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return SettingsEmailTemplate the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_email_template';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {

                return array(
                    array('key,description, subject, body, from', 'required'),
                    array('created_by', 'numerical', 'integerOnly' => true),
                    array('key,description', 'length', 'max' => 128),
                    array('from', 'email'),
                    array('subject, from', 'length', 'max' => 255),
                    array('comments', 'safe'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'key' => Lang::t('Key'),
                    'subject' => Lang::t('Subject'),
                    'body' => Lang::t('Body'),
                    'from' => Lang::t('From'),
                    'description' => Lang::t('Description'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('id', self::SEARCH_FIELD, true, 'OR'),
                    array('description', self::SEARCH_FIELD, true, 'OR'),
                    'id',
                );
        }

        /**
         * Find email template by key
         * @param type $key
         * @return type
         * @throws CHttpException
         */
        public function findByKey($key)
        {
                $model = $this->find('`key`=:t1', array(':t1' => $key));
                if ($model === null)
                        throw new CHttpException(500, 'No email template with the given key: ' . $key);
                return $model;
        }

}

