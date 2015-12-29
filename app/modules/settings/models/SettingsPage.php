<?php

/**
 * This is the model class for table "settings_page".
 *
 * The followings are the available columns in table 'settings_page':
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $allow_indexing
 * @property string $content
 * @property integer $add_content
 * @property string $date_created
 * @property string $last_modified
 */
class SettingsPage extends ActiveRecord {
        //common pages

        const PAGE_HOME_PAGE = 'home_page';
        const PAGE_ABOUT_US = 'about_us';
        const PAGE_SOLUTIONS = 'solutions';
        const PAGE_CONTACT_US = 'contact_us';
        const PAGE_TERMS = 'terms';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_page';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('key,name, title', 'required'),
                    array('allow_indexing,add_content', 'numerical', 'integerOnly' => true),
                    array('name, title,description', 'length', 'max' => 255),
                    array('key', 'length', 'max' => 30),
                    array('content,date_created,last_modified', 'safe'),
                    array('content', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')), //html purification
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
                    'name' => Lang::t('Page Name'),
                    'title' => Lang::t('Page Title'),
                    'content' => Lang::t('Page Content'),
                    'description' => Lang::t('Page description'),
                    'allow_indexing' => Lang::t('Allow indexing'),
                    'date_created' => Lang::t('Date Created'),
                    'last_modified' => Lang::t('Last Modified'),
                    'add_content' => Lang::t('Add content'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsPage the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'key',
                    'id',
                    'add_content'
                );
        }

        public function findByKey($key)
        {
                $model = $this->find('`key`=:t1', array(':t1' => $key));
                if ($model === null)
                        throw new CHttpException(404, Lang::t('404_error'));
                return $model;
        }

        /**
         * Find content by key
         * @param type $key
         * @return type
         */
        public function getContentByKey($key)
        {
                return $this->getScaler('content', '`key`=:t1', array(':t1' => $key));
        }

}
