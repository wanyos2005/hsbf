<?php

/**
 * This is the model class for table "help_topic".
 *
 * The followings are the available columns in table 'help_topic':
 * @property integer $id
 * @property string $topic
 * @property string $body
 * @property integer $category_id
 * @property integer $created_by
 * @property string $date_created
 * @property string $last_modified
 *
 * The followings are the available model relations:
 * @property HelpCategory $category
 */
class HelpTopic extends ActiveRecord {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return HelpTopic the static model class
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
                return 'help_topic';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('topic, body, category_id', 'required'),
                    array('category_id, created_by', 'numerical', 'integerOnly' => true),
                    array('topic', 'length', 'max' => 128),
                    array('last_modified,date_created', 'safe'),
                    array('id,_search', 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'category' => array(self::BELONGS_TO, 'HelpCategory', 'category_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'topic' => Lang::t('Topic'),
                    'body' => Lang::t('Body'),
                    'category_id' => Lang::t('Category'),
                    'created_by' => Lang::t('Created By'),
                    'date_created' => Lang::t('Date Created'),
                    'last_modified' => Lang::t('Last Modified'),
                );
        }

        public function searchParams()
        {
                return array(
                    array('topic', '_search', true),
                    'id',
                    'category_id',
                );
        }

}

