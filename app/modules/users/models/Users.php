<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
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
 * @property string $last_login
 * @property string $security_question
 * @property string $answer
 */
class Users extends ActiveRecord {

    const SCENARIO_CHANGE_PASSWORD = 'changePass'; //When a user's password is changed by the admin or a user recovers password (forgot password)
    const SCENARIO_RESET_PASSWORD = 'resetPass';
    const SCENARIO_ACTIVATE_ACCOUNT = 'activation';
    const SCENARIO_SIGNUP = 'sign_up';
    //status constants
    const STATUS_ACTIVE = 'Active';
    const STATUS_PENDING = 'Pending';
    const STATUS_BLOCKED = 'Blocked';
    //user resource prefix
    const USER_RESOURCE_PREFIX = 'USER_';

    //holder for dept_id
    public $dept_id;

    /**
     *
     * @var type
     */
    public $send_email = false;

    /**
     * confirm password
     * @var type
     */
    public $confirm;

    /**
     * Current user password
     * Used for when a user wants to change his/her password
     * @var type
     */
    public $currentPassword;

    /**
     * temp buffer for new password during password reset action
     * @var type
     */
    public $pass;

    /**
     *
     * @var type
     */
    public $verifyCode;

    //profile actions constants
    const ACTION_UPDATE_PERSONAL = 'u_personal';
    const ACTION_UPDATE_ACCOUNT = 'u_account';
    const ACTION_UPDATE_ADDRESS = 'u_address';
    const ACTION_RESET_PASSWORD = 'reset_p';
    const ACTION_CHANGE_PASSWORD = 'change_p';
    const ACTION_ADD_DEPENDENTS = 'add_dependents';
    const ACTION_ADD_KINS = KinsAndNominees::NEXT_OF_KIN;
    const ACTION_ADD_NOMINEES = KinsAndNominees::NOMINEE;

    public function behaviors() {
        $behaviors = array();
        $behaviors['UserBehavior'] = array(
            'class' => 'application.modules.users.components.behaviors.UserBehavior',
        );
        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('username, email, password, salt, user_level, security_question, answer', 'required'),
            array('role_id, created_by', 'numerical', 'integerOnly' => true),
            array('last_modified_by, answer', 'length', 'max' => 11),
            array('username, user_level', 'length', 'max' => 30),
            array('email, password, salt, password_reset_code, activation_code', 'length', 'max' => 128),
            array('status', 'length', 'max' => 15),
            array('timezone', 'length', 'max' => 60),
            array('password_reset_date, password_reset_request_date, last_modified', 'safe'),
            array('email', 'email', 'message' => Lang::t('Please enter a valid email address')),
            array('username,email', 'unique', 'message' => Lang::t('{value} is not available')),
            array('username,password', 'length', 'min' => 4, 'max' => 20, 'on' => ActiveRecord::SCENARIO_CREATE . ',' . self::SCENARIO_SIGNUP, 'message' => Lang::t('{attribute} length should be between {min} and {max}.')),
            array('confirm', 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_CHANGE_PASSWORD . ',' . ActiveRecord::SCENARIO_CREATE . ',' . self::SCENARIO_RESET_PASSWORD . ',' . self::SCENARIO_SIGNUP, 'message' => Lang::t('Passwords do not match.')),
            array('currentPassword', 'compare', 'compareAttribute' => 'pass', 'on' => self::SCENARIO_CHANGE_PASSWORD, 'message' => Lang::t('{attribute} is wrong')),
            array('currentPassword', 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD),
            array('username', 'match', 'pattern' => '/^([a-zA-Z0-9_])+$/', 'message' => Lang::t('{attribute} can contain only alphanumeric characters and/or underscore(_).')),
            array('send_email,confirm,dept_id', 'safe'),
            array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Lang::t('ID'),
            'username' => Lang::t('Username'),
            'email' => Lang::t('Email'),
            'status' => Lang::t('Status'),
            'password' => Lang::t('Password'),
            'confirm' => Lang::t('Confirm Password'),
            'date_created' => Lang::t('Joined'),
            'created_by' => Lang::t('Created By'),
            'user_level' => Lang::t('Level'),
            'role_id' => Lang::t('Role'),
            'timezone' => Lang::t('Timezone'),
            'last_login' => Lang::t('Last Login'),
            'security_question' => Lang::t('Security Quiz'),
            'answer' => Lang::t('Answer'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterSave() {
        if ($this->scenario === self::SCENARIO_UPDATE) {
            $this->updateDeptUser();
            Dept::model()->updateContactPerson($this->dept_id, $this->id);
        }
        return parent::afterSave();
    }

    public function afterFind() {
        $this->dept_id = $this->getDeptId($this->id);
        return parent::afterFind();
    }

    public function beforeDelete() {
        Person::model()->loadModel($this->id)->delete();
        return parent::beforeDelete();
    }

    /**
     * Validate password for login
     * @param type $password
     * @return type
     */
    public function validatePassword($password) {
        return $this->salt . md5($password) === $this->password;
    }

    /**
     * Get user levels to display in the dropdown list
     * @param type $controller
     * @return type
     */
    public function getUserLevels($controller) {
        $values = UserLevels::model()->getListData('id', 'description', false, '`id`<>:t1', array(':t1' => UserLevels::LEVEL_MEMBER), 'rank desc');

        foreach ($values as $k => $v) {
            if (!$controller->showLink(self::USER_RESOURCE_PREFIX . $k))
                unset($values[$k]);
        }

        return $values;
    }

    /**
     * Get user acc status (mainly for displayinng in dropdown list)
     * @return type
     */
    public static function statusOptions() {
        return array(
            self::STATUS_ACTIVE => Lang::t(self::STATUS_ACTIVE),
            self::STATUS_PENDING => Lang::t(self::STATUS_PENDING),
            self::STATUS_BLOCKED => Lang::t(self::STATUS_BLOCKED),
        );
    }

    /**
     * Get fetch condition based on the user level
     * @return string
     * @throws CHttpException
     */
    public function getFetchCondition() {
        $condition = '(`user_level`<>"' . UserLevels::LEVEL_MEMBER . '")';
        switch (Controller::$user_level) {
            case UserLevels::LEVEL_ENGINEER:
                $condition .= "";
                break;
            case UserLevels::LEVEL_SUPERADMIN:
                $condition .= ' AND (`user_level`<>"' . UserLevels::LEVEL_ENGINEER . '")';
                break;
            case UserLevels::LEVEL_ADMIN:
                $condition .= ' AND (`user_level`<>"' . UserLevels::LEVEL_ENGINEER . '" AND `user_level`<>"' . UserLevels::LEVEL_SUPERADMIN . '")';
                break;
            default :
                throw new CHttpException(403, Lang::t('403_error'));
        }

        return $condition;
    }

    /**
     * Whether the logged in user can update a given user
     * @param type $controller
     * @return type
     */
    public function canBeModified($controller, $type = Acl::ACTION_UPDATE) {
        return $controller->showLink(self::USER_RESOURCE_PREFIX . $this->user_level, $type) && Controller::$user_level !== $this->user_level;
    }

    /**
     * Get dept id of a user
     * @param type $id
     * @return type
     */
    public function getDeptId($id) {
        if (empty($id))
            return NULL;
        $dept_id = DeptUser::model()->getScaler('dept_id', '`person_id`=:t1 AND `has_left`=:t2', array(':t1' => $id, ':t2' => 0));
        return !empty($dept_id) ? $dept_id : NULL;
    }

    /**
     * Update user dept
     */
    public function updateDeptUser() {
        if (!empty($this->dept_id)) {
            if (!DeptUser::model()->exists('`person_id`=:t1 AND `dept_id`=:t2 AND `has_left`=:t3', array(':t1' => $this->id, ':t2' => $this->dept_id, ':t3' => 0))) {
                DeptUser::model()->removeUserFromDept($this->id);
                DeptUser::model()->addUserToDept(array(
                    'person_id' => $this->id,
                    'dept_id' => $this->dept_id,
                    'date_created' => new CDbExpression('NOW()'),
                    'created_by' => Yii::app() instanceof CWebApplication ? Yii::app()->user->id : NULL,
                ));
            }
        } else {
            DeptUser::model()->removeUserFromDept($this->id);
        }
    }

    /**
     * Check whether account belongs to a user
     * @param type $id
     * @return type
     */
    public static function isMyAccount($id) {
        return $id === Yii::app()->user->id;
    }

    /**
     * Update last login
     * @param type $id
     * @return type
     */
    public function updateLastLogin($id) {
        return Yii::app()->db->createCommand()
                        ->update($this->tableName(), array('last_login' => new CDbExpression('NOW()')), '`id`=:t1', array(':t1' => $id));
    }

    /**
     * Return user account of a member
     * 
     * @param type $member
     * @return \Users
     */
    public function memberAsUser($member) {
        return Users::model()->findByPk($member);
    }

    /**
     * Update user account at member withdrawal
     * 
     * @param type $withdrawer
     */
    public function userStatus($withdrawer) {
        $user = Users::model()->memberAsUser($withdrawer->member);

        if (!empty($user)) {
            if ($withdrawer->status == 'Yes')
                $user->status = self::STATUS_ACTIVE;
            else
            if ($withdrawer->status == self::STATUS_PENDING)
                $user->status = self::STATUS_PENDING;
            else
            if ($withdrawer->status == 'No')
                $user->status = self::STATUS_BLOCKED;

            $user->save(false);
        }
    }
    
    /**
     * 
     * @param \Users $account
     * @return boolean
     * TRUE: Account is Active.
     * FALSE: Account is not Active.
     */
    public function accountActive($account) {
        if ($account->status == self::STATUS_ACTIVE)
            return true;
    }

}
