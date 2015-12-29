<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends FormModel {

    public $username;
    public $password;
    public $rememberMe = false;

    /**
     *
     * @var UserIdentity
     */
    public $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => Lang::t('Keep me logged in'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!$this->_identity->authenticate()) {
                //error code 4:Account not active
                if ($this->_identity->errorCode === UserIdentity::ERROR_ACC_PENDING)//not activated
                    $this->addError('username', Lang::t('ACC_NOT_ACTIVATED_NOTICE'));
                else if ($this->_identity->errorCode === UserIdentity::ERROR_ACC_BLOCKED)//account blocked
                    $this->addError('username', Lang::t('ACC_BLOCKED_NOTICE'));
                //warehouse closed
                else if ($this->_identity->errorCode === UserIdentity::ERROR_DEPT_CLOSED)
                    $this->addError('username', Lang::t('Your department has been marked as closed. Please contact the administrator for assistance.'));
                else
                    $this->addErrors(array('password' => '', 'username' => Lang::t('Incorrect login details given')));
            }
        }
    }

}
