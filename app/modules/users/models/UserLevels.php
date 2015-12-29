<?php

/**
 * This is the model class for table "user_levels".
 *
 * The followings are the available columns in table 'user_levels':
 * @property string $id
 *  @property string $description
 * @property string $banned_resources
 * @property string $banned_resources_inheritance
 * @property integer $rank
 */
class UserLevels extends ActiveRecord implements IMyActiveSearch {

        const LEVEL_ENGINEER = 'ENGINEER';
        const LEVEL_SUPERADMIN = 'SUPERADMIN';
        const LEVEL_ADMIN = 'ADMIN';
        const LEVEL_MEMBER = 'MEMBER';

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return UserLevels the static model class
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
                return 'user_levels';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('id,description,rank', 'required'),
                    array('id', 'length', 'max' => 255),
                    array('id,description', 'unique', 'message' => '{value} already exists.'),
                    array('banned_resources,banned_resources_inheritance', 'safe'),
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
                    'id' => 'Level',
                    'description' => 'Description',
                    'rank' => 'Rank',
                    'banned_resources' => 'Banned Resources',
                    'banned_resources_inheritance' => 'Parent',
                );
        }

        public function searchParams()
        {
                return array(
                    array('description', self::SEARCH_FIELD, true, 'OR'),
                    array('id', self::SEARCH_FIELD, true, 'OR'),
                );
        }

        public function beforeSave()
        {
                if ($this->id === self::LEVEL_ENGINEER)
                        $this->banned_resources_inheritance = NULL;
                return parent::beforeSave();
        }

}
