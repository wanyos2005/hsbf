<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

        const ERROR_ACC_PENDING = 'Pending';
        const ERROR_ACC_BLOCKED = 'Blocked';
        const ERROR_DEPT_CLOSED = 'Store_Closed';
        //user state constants
        const STATE_AUDIT_TRAIL = 'audit_trail';
        const STATE_USER_LEVEL = 'user_level';
        const STATE_DEPT_ID = 'warehouse_id';
        const STATE_HOME_MODULE = 'base_module';

        public $_id;

        /**
         * The user model
         * @var type
         */
        public $user;

        /**
         * Flag on whether to log audit trail or not
         * @var type
         */
        public $auditTrail = true;

        /**
         * Authenticates a user.
         * The example implementation makes sure if the username and password
         * are both 'demo'.
         * In practical applications, this should be changed to authenticate
         * against some persistent user identity storage (e.g. database).
         * @return boolean whether authentication succeeds.
         */
        public function authenticate()
        {
                $dept_id = $this->user !== NULL ? Users::model()->getDeptId($this->user->id) : NULL;
                if ($this->user === null) {
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                } else if (!$this->user->validatePassword($this->password)) {
                        $this->errorCode = self::ERROR_PASSWORD_INVALID;
                } else if ($this->user->status === Users::STATUS_BLOCKED) {
                        $this->errorCode = self::ERROR_ACC_BLOCKED;
                } else if ($this->user->status === Users::STATUS_PENDING) {
                        $this->errorCode = self::ERROR_ACC_PENDING;
                } else if (!empty($dept_id) && (Dept::model()->get($dept_id, 'status') === Dept::STATUS_CLOSED)) {
                        $this->errorCode = self::ERROR_DEPT_CLOSED;
                } else {
                        $this->completeLogin($dept_id);
                }

                return $this->errorCode === self::ERROR_NONE;
        }

        public function getId()
        {
                return $this->_id;
        }

        /**
         * Add login log for Admin/Staff users
         */
        protected function addLogInLog()
        {
                UserLoginLog::model()->addRecord(array(
                    'user_id' => $this->_id,
                    'ip' => Common::getIp(),
                ));
        }

        protected function completeLogin($dept_id = NULL)
        {
                $this->errorCode = self::ERROR_NONE;

                $this->_id = $this->user->id;
                $this->username = $this->user->username;
                $this->setState(self::STATE_AUDIT_TRAIL, $this->auditTrail);
                $this->setState(self::STATE_USER_LEVEL, $this->user->user_level);
                $this->setState(self::STATE_DEPT_ID, $dept_id);
                $base_module = null;
                if ($this->user->user_level !== UserLevels::LEVEL_MEMBER)
                        $base_module = 'admin';
                $this->setState(self::STATE_HOME_MODULE, $base_module);

                if (!empty($this->user->timezone))
                        Yii::app()->localtime->setTimezone($this->user->timezone);
                //update last login
                Users::model()->updateLastLogin($this->user->id);
                //add activity log
                UserActivity::model()->addActivity($this->user->id, UserActivity::TYPE_LOGIN, Lang::t("{name} signed in successfully", array('{name}' => $this->user->username)));
        }

        /**
         * Sign in user by creating necessary sessions
         * @param type $remember
         * @return boolean
         */
        public function login($remember = FALSE)
        {
                if ($this->errorCode === self::ERROR_NONE) {
                        $duration = $remember ? 3600 * 24 * 30 : 0; // 30 days for remember me else 0(until the browser is closed )
                        Yii::app()->user->login($this, $duration);
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * The user must have been authenticated for you to call this function e.g A user who activated his account via email activation link.
         * @param Users $model
         */
        public function automaticLogin($model)
        {
                $this->user = $model;
                $this->completeLogin();
                return $this->login();
        }

}
