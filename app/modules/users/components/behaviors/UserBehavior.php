<?php

/**
 * System user behavior
 */
class UserBehavior extends CActiveRecordBehavior {

        public function beforeSave($event)
        {
                $owner = $this->getOwner();
                //concatenate the salt with password
                if ($owner->hasAttribute('password') && ($owner->getIsNewRecord() || $owner->getScenario() === Users::SCENARIO_CHANGE_PASSWORD || $owner->getScenario() === Users::SCENARIO_RESET_PASSWORD)) {
                        $owner->genericField = $owner->password;
                        $owner->password = $owner->salt . md5($owner->password);
                }
                return parent::beforeSave($event);
        }

        public function beforeValidate($event)
        {
                $owner = $this->getOwner();
                //salt
                if ($owner->getIsNewRecord() && $owner->hasAttribute('salt'))
                        $owner->salt = Common::generateSalt();

                if ($owner->getScenario() === Users::SCENARIO_CHANGE_PASSWORD)
                        $owner->currentPassword = $owner->salt . md5($owner->currentPassword);

                return parent::beforeValidate($event);
        }

        public function afterSave($event)
        {
                $owner = $this->getOwner();

                if ($owner->getIsNewRecord() && $owner->send_email) {
                        $this->accountDetailsEmail();
                }
                if ($owner->getScenario() === Users::SCENARIO_RESET_PASSWORD && $owner->send_email) {
                        $this->newPasswordEmail();
                }
                if ($owner->getIsNewRecord() && $owner->getScenario() === Users::SCENARIO_SIGNUP) {
                        $this->sendAccActivationEmail();
                }

                return parent::afterSave($event);
        }

        protected function accountDetailsEmail()
        {
                $owner = $this->getOwner();

                $template = SettingsEmailTemplate::model()->getRow('*', '`key`=:t1', array(':t1' => SettingsEmailTemplate::KEY_NEW_USER));
                if (empty($template))
                        return FALSE;

                $site_name = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_SITE_NAME, Yii::app()->name);
                //placeholders: {name},{site_name},{link},{username} {email},{password},
                $body = Common::myStringReplace($template['body'], array(
                            '{name}' => Person::model()->get($owner->id, 'CONCAT(`first_name`," ",`last_name`)'),
                            '{site_name}' => $site_name,
                            '{link}' => Yii::app()->createAbsoluteUrl('auth/default/login'),
                            '{username}' => $owner->username,
                            '{email}' => $owner->email,
                            '{password}' => $owner->genericField,
                ));

                MsgEmailOutbox::model()->push(array(
                    'from_name' => $site_name,
                    'from_email' => $template['from'],
                    'to_email' => $owner->email,
                    'subject' => $template['subject'],
                    'message' => $body,
                ));
        }

        protected function newPasswordEmail()
        {
                $owner = $this->getOwner();

                $template = SettingsEmailTemplate::model()->getRow('*', '`key`=:t1', array(':t1' => SettingsEmailTemplate::KEY_RESET_PASSWORD));
                if (empty($template))
                        return FALSE;

                $site_name = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_SITE_NAME, Yii::app()->name);
                //placeholders: {name},{link},{username} {email},{password},
                $body = Common::myStringReplace($template['body'], array(
                            '{name}' => Person::model()->get($owner->id, 'CONCAT(`first_name`," ",`last_name`)'),
                            '{link}' => Yii::app()->createAbsoluteUrl('auth/default/login'),
                            '{username}' => $owner->username,
                            '{email}' => $owner->email,
                            '{password}' => $owner->genericField,
                ));

                MsgEmailOutbox::model()->push(array(
                    'from_name' => $site_name,
                    'from_email' => $template['from'],
                    'to_email' => $owner->email,
                    'subject' => $template['subject'],
                    'message' => $body,
                ));
        }

        public function sendAccActivationEmail()
        {
                $owner = $this->getOwner();

                $template = SettingsEmailTemplate::model()->getRow('*', '`key`=:t1', array(':t1' => SettingsEmailTemplate::KEY_ACCOUNT_ACTIVATION));
                if (empty($template))
                        return FALSE;

                $site_name = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_SITE_NAME, Yii::app()->name);
                //placeholders: {name},{link},
                $body = Common::myStringReplace($template['body'], array(
                            '{name}' => $owner->username,
                            '{link}' => Yii::app()->createAbsoluteUrl('auth/default/activate', array('id' => $owner->id, 'token' => $owner->activation_code)),
                ));

                MsgEmailOutbox::model()->push(array(
                    'from_name' => $site_name,
                    'from_email' => $template['from'],
                    'to_email' => $owner->email,
                    'subject' => $template['subject'],
                    'message' => $body,
                ));
        }

}
