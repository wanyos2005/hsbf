<?php

/**
 * This is the model class for table "dept_user".
 *
 * The followings are the available columns in table 'dept_user':
 * @property string $id
 * @property string $person_id
 * @property string $dept_id
 * @property integer $has_left
 * @property string $reason_for_leaving
 * @property string $date_left
 * @property string $date_created
 * @property string $created_by
 * @property string $last_modified
 * @property string $last_modified_by
 */
class DeptUser extends ActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'dept_user';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('person_id, dept_id', 'required'),
                    array('has_left', 'numerical', 'integerOnly' => true),
                    array('person_id, dept_id, created_by, last_modified_by', 'length', 'max' => 11),
                    array('reason_for_leaving', 'length', 'max' => 255),
                    array('date_left, last_modified', 'safe'),
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
                    'person_id' => Lang::t('Person'),
                    'dept_id' => Lang::t('Department'),
                    'has_left' => Lang::t('Has Left'),
                    'reason_for_leaving' => Lang::t('Reason For Leaving'),
                    'date_left' => Lang::t('Date Left'),
                    'date_created' => Lang::t('Date Created'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return DeptUser the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * Add user to a department
         * @param array $columns
         * @return type
         */
        public function addUserToDept(array $columns)
        {
                return Yii::app()->db->createCommand()
                                ->insert(DeptUser::model()->tableName(), $columns);
        }

        /**
         * Remove user from dept
         * @param type $person_id
         * @return type
         */
        public function removeUserFromDept($person_id)
        {
                $now = new CDbExpression('NOW()');
                $creator = Yii::app() instanceof CWebApplication ? Yii::app()->user->id : NULL;
                return Yii::app()->db->createCommand()
                                ->update(DeptUser::model()->tableName(), array('has_left' => 1, 'date_left' => $now, 'last_modified' => $now, 'last_modified_by' => $creator), '`person_id`=:t1 AND `has_left`=:t2', array(':t1' => $person_id, ':t2' => 0));
        }

}
