<?php

/**
 * This is the model class for table "users_view".
 *
 * The followings are the available columns in table 'users_view':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $status
 * @property string $timezone
 * @property string $password
 * @property string $salt
 * @property string $password_reset_code
 * @property string $password_reset_date
 * @property string $password_reset_request_date
 * @property string $activation_code
 * @property string $user_level
 * @property integer $role_id
 * @property string $date_created
 * @property integer $created_by
 * @property string $last_modified
 * @property string $last_modified_by
 * @property string $name
 * @property string $gender
 * @property integer $dept_id
 */
class UsersView extends Users implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'users_view';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('id, username, email, status, user_level, name, gender,dept_id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        public function primaryKey()
        {
                return 'id';
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array_merge(parent::attributeLabels(), array(
                    'name' => Lang::t('Name'),
                    'gender' => Lang::t('Gender'),
                ));
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return UsersView the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('username', self::SEARCH_FIELD, true, 'OR'),
                    array('name', self::SEARCH_FIELD, true, 'OR'),
                    array('email', self::SEARCH_FIELD, true, 'OR'),
                    'id',
                    'dept_id',
                    'status',
                    'user_level',
                    'gender',
                );
        }

}
