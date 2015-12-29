<?php

/**
 * This is the model class for table "help_category".
 *
 * The followings are the available columns in table 'help_category':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $date_created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property HelpTopic[] $helpTopics
 */
class HelpCategory extends ActiveRecord {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return HelpCategory the static model class
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
                return 'help_category';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('name', 'required'),
                    array('created_by', 'numerical', 'integerOnly' => true),
                    array('name', 'length', 'max' => 128),
                    array('description,date_created', 'safe'),
                    array('id,_search', 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'helpTopics' => array(self::HAS_MANY, 'HelpTopic', 'category_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'name' => Lang::t('Name'),
                    'description' => Lang::t('Description'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('name', '_search', true),
                    'id',
                );
        }

}

