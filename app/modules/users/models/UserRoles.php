<?php

/**
 * This is the model class for table "user_roles".
 *
 * The followings are the available columns in table 'user_roles':
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property UserRolesOnResources[] $userRolesOnResources
 */
class UserRoles extends ActiveRecord implements IMyActiveSearch {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return UserRoles the static model class
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
                return 'user_roles';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('name', 'length', 'max' => 128),
                    array('description', 'length', 'max' => 255),
                    array('name', 'unique', 'message' => '{value} already exists.'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'userRolesOnResources' => array(self::HAS_MANY, 'UserRolesOnResources', 'role_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Role'),
                    'description' => Lang::t('Description'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'id',
                );
        }

}
