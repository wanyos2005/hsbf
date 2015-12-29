<?php

/**
 * Forgot password form
 */
class ForgotPasswordForm extends FormModel {

        /**
         * Could be username or email
         * @var type
         */
        public $username;

        /**
         * Success message if validation is passed
         * @var type
         */
        public $success_message;

        /**
         * User model
         * @var Users
         */
        public $user_model;

        /**
         * The context module of this class
         * @var type
         */
        public $context_module = null;

        public function rules()
        {
                return array(
                    array('username', 'required', 'message' => 'Username or Email is required.'),
                    array('username', 'authenticate'),
                );
        }

        public function attributeLabels()
        {
                return array(
                    'username' => 'Username or Email',
                );
        }

        public function beforeValidate()
        {
                $this->getUserModel();
                return parent::beforeValidate();
        }

        public function afterValidate()
        {
                if (!$this->hasErrors()) {
                        $this->sendEmail();
                        $this->success_message = Lang::t('Check this email ({email}) for instructions on how to get a new password.If you don\'t get email please check your spam and mark it as "not spam"', array('{email}' => $this->user_model->email));
                }
                return parent::afterValidate();
        }

        public function authenticate()
        {
                if (!$this->hasErrors() && $this->user_model === NULL)
                        $this->addError('username', 'No account associated with the Username/Email.');
        }

        public function getUserModel()
        {
                $this->user_model = Users::model()->find('`username`=:t1 OR `email`=:t1', array(':t1' => $this->username));
        }

        public function sendEmail()
        {

                $this->user_model->password_reset_code = Common::generateSalt();
                $this->user_model->password_reset_request_date = date('Y-m-d H:i:s');
                $this->user_model->save(false);

                $template = SettingsEmailTemplate::model()->getRow('*', '`key`=:t1', array(':t1' => SettingsEmailTemplate::KEY_FORGOT_PASSWORD));
                if (empty($template))
                        return FALSE;

                //placeholders : {name},{link}
                $body = Common::myStringReplace($template['body'], array(
                            '{name}' => Person::model()->get($this->user_model->id, 'CONCAT(first_name," ",last_name)'),
                            '{link}' => Yii::app()->createAbsoluteUrl('auth/default/resetPassword', array('id' => $this->user_model->id, 'token' => $this->user_model->password_reset_code)),
                ));

                //$from, $this->user_model->email, $template->title, $template->body, true
                MsgEmailOutbox::model()->push(array(
                    'from_name' => Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_SITE_NAME, Yii::app()->name),
                    'from_email' => $template['from'],
                    'to_email' => $this->user_model->email,
                    'subject' => $template['subject'],
                    'message' => $body,
                ));
        }

}
