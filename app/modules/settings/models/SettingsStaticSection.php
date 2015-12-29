<?php

/**
 * This is the model class for table "settings_section".
 *
 * The followings are the available columns in table 'settings_section':
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $content
 * @property string $comments
 * @property string $date_created
 * @property integer $created_by
 */
class SettingsStaticSection extends ActiveRecord implements IMyActiveSearch {
        //section keys

        const FRONTEND_HOME_PAGE_INTRO = 'frontend_home_page_intro';
        const FRONTEND_LOGIN_PAGE_DESC = 'frontend_login_page_description';
        const FRONTEND_SIGNUP_PAGE_DESC = 'frontend_signup_page_description';
        const FRONTEND_START_SELLING = 'frontend_start_selling';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'settings_static_sections';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('key, name', 'required'),
                    array('created_by', 'numerical', 'integerOnly' => true),
                    array('key', 'length', 'max' => 64),
                    array('name', 'length', 'max' => 128),
                    array('content,comments', 'safe'),
                    array('content', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')), //html purification
                    array('key,name', 'unique', 'message' => '{value} already exists.'),
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
                    'name' => Lang::t('Name'),
                    'content' => Lang::t('Content'),
                    'comments' => Lang::t('Comments'),
                    'date_created' => Lang::t('Date Created')
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SettingsStaticSection the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('name', self::SEARCH_FIELD, true),
                    'id',
                    'key',
                );
        }

        public function findByKey($key)
        {
                $model = $this->find('`key`=:t1', array(':t1' => $key));
                if ($model === null)
                        throw new CHttpException(404, Lang::t('404_error'));
                return $model;
        }

        public function getContentByKey($key)
        {
                return $this->getScaler('content', '`key`=:t1', array(':t1' => $key));
        }

}
