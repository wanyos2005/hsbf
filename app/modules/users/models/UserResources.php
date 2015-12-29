<?php

/**
 * This is the model class for table "user_resources".
 *
 * The followings are the available columns in table 'user_resources':
 * @property string $id
 * @property string $description
 * @property integer $viewable
 * @property integer $createable
 * @property integer $updateable
 * @property integer $deleteable
 *
 * The followings are the available model relations:
 * @property UserRolesOnResources[] $usersRolesOnResources
 */
class UserResources extends ActiveRecord {

        //system resources should correspond to those saved in the db:

        const RES_SETTINGS_GENERAL = 'SETTINGS_GENERAL';
        const RES_SETTINGS_EMAIL = 'SETTINGS_EMAIL';
        const RES_SETTINGS_RUNTIME = 'SETTINGS_RUNTIME';
        const RES_SETTINGS_TOWN = 'SETTINGS_TOWN';
        const RES_SETTINGS_UNITS_OF_MEASURE = 'SETTINGS_UNITS_OF_MEASURE';
        const RES_SETTINGS_TAXES = 'SETTINGS_TAXES';
        const RES_SETTINGS_CRON = 'SETTINGS_CRON';
        const RES_MODULES_ENABLED = 'MODULES_ENABLED';
        const RES_USER_ROLES = 'USER_ROLES';
        const RES_USER_RESOURCES = 'USER_RESOURCES';
        const RES_USER_ENGINEER = 'USER_ENGINEER';
        const RES_USER_SUPERADMIN = 'USER_SUPERADMIN';
        const RES_USER_ADMIN = 'USER_ADMIN';
        const RES_USER_DEFAULT = 'USER_DEFAULT';
        const RES_USER_LEVELS = 'USER_LEVELS';
        const RES_USER_ACTIVITY = 'USER_ACTIVITY';
        const RES_DOCUMENTATION = 'DOCUMENTATION';
        const RES_MESSAGE = 'MESSAGE';
        const RES_DEPT = 'DEPT';
        const RES_INCOME = 'INCOME';
        const RES_PARKING = 'PARKING';
        const RES_BUSINESS_PERMIT = 'BUSINESS_PERMIT';
        const RES_LAND_RATES = 'LAND_RATES';
        const RES_CESS = 'CESS';
        const RES_MARKET_FEES = 'MARKET_FEES';

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return UserResources the static model class
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
                return 'user_resources';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {

                return array(
                    array('id,description', 'required'),
                    array('viewable, createable, updateable, deleteable', 'numerical', 'integerOnly' => true),
                    array('id', 'length', 'max' => 128),
                    array('id', 'unique'),
                    array('description', 'length', 'max' => 255),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'usersRolesOnResources' => array(self::HAS_MANY, 'UserRolesOnResources', 'resource_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'description' => Lang::t('Description'),
                    'viewable' => Lang::t('Viewable'),
                    'createable' => Lang::t('Createable'),
                    'updateable' => Lang::t('Updateable'),
                    'deleteable' => Lang::t('Deleteable'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('description', self::SEARCH_FIELD, true, 'OR'),
                    array('id', self::SEARCH_FIELD, true, 'OR'),
                    'id',
                );
        }

        /**
         * Get resources
         * @param type $exluded_resources. Resources not to be included
         * @return type
         */
        public function getResources($exluded_resources = null)
        {
                $command = Yii::app()->db->createCommand()
                        ->select()
                        ->from($this->tableName());
                if (!empty($exluded_resources))
                        $command->where(array('NOT IN', 'id', $exluded_resources));
                return $command->queryAll();
        }

}
