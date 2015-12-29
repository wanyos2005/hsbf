<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AdminLoginForm extends LoginForm {

        /**
         * Declares the validation rules.
         * The rules state that username and password are required,
         * and password needs to be authenticated.
         */
        public function rules()
        {
                return array_merge(parent::rules(), array(
                ));
        }

        /**
         * Declares attribute labels.
         */
        public function attributeLabels()
        {
                return array_merge(parent::attributeLabels(), array(
                    'rememberMe' => Lang::t('Keep me logged in'),
                ));
        }

        /**
         * Authenticates the password.
         * This is the 'authenticate' validator as declared in rules().
         */
        public function authenticate($attribute, $params)
        {
                parent::authenticate($attribute, $params);
        }

}
