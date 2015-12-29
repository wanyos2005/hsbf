<?php

/**
 * This is the model class for table "user_roles_on_resources".
 *
 * The followings are the available columns in table 'user_roles_on_resources':
 * @property integer $id
 * @property integer $role_id
 * @property string $resource_id
 * @property integer $view
 * @property integer $create
 * @property integer $update
 * @property integer $delete
 *
 * The followings are the available model relations:
 * @property UserRoles $role
 * @property UserResources $resource
 */
class UserRolesOnResources extends ActiveRecord {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return UserRolesOnResources the static model class
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
                return 'user_roles_on_resources';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('role_id, resource_id', 'required'),
                    array('role_id, view, create, update, delete', 'numerical', 'integerOnly' => true),
                    array('resource_id', 'length', 'max' => 128),
                    array('id', 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'role' => array(self::BELONGS_TO, 'UserRoles', 'role_id'),
                    'resource' => array(self::BELONGS_TO, 'UserResources', 'resource_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => 'ID',
                    'resource_id' => 'Resource',
                    'view' => 'View',
                    'create' => 'Create',
                    'update' => 'Update',
                    'delete' => 'Delete',
                );
        }

        /**
         *
         * @param type $resource_id
         * @param type $role_id
         * @param type $action
         * @param type $default
         */
        public function getValue($resource_id, $role_id, $action, $default = NULL)
        {
                $model = $this->find('`role_id`=:role_id AND `resource_id`=:resource_id', array(':role_id' => $role_id, ':resource_id' => $resource_id));
                if ($model !== NULL)
                        return $model->$action;
                if ($default !== NULL)
                        return $default;
                return FALSE;
        }

        /**
         *
         * @param type $resource_id
         * @param type $role_id
         * @param type $values
         */
        public function set($resource_id, $role_id, $values)
        {
                $model = $this->find('`role_id`=:role_id AND `resource_id`=:resource_id', array(':role_id' => $role_id, ':resource_id' => $resource_id));
                if ($model === NULL) {
                        $model = new UserRolesOnResources();
                        $model->resource_id = $resource_id;
                        $model->role_id = $role_id;
                }

                foreach ($values as $key => $val) {
                        $model->$key = (int) $val;
                }
                if ($model->save())
                        return TRUE;
                return FALSE;
        }

}
