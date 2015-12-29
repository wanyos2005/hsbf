<?php

/**
 * Self registration
 * @author Fred <mconyango@gmail.com>
 */
class RegisterController extends AuthModuleController {

        public function init()
        {
                // register class paths for extension captcha extended
                Yii::$classMap = array_merge(Yii::$classMap, array(
                    'CaptchaExtendedAction' => Yii::getPathOfAlias('ext.captcha') . DIRECTORY_SEPARATOR . 'CaptchaExtendedAction.php',
                    'CaptchaExtendedValidator' => Yii::getPathOfAlias('ext.captcha') . DIRECTORY_SEPARATOR . 'CaptchaExtendedValidator.php'
                ));
                parent::init();
        }

        public function actions()
        {
                return array(
                    'captcha' => array(
                        'class' => 'CaptchaExtendedAction',
                        // if needed, modify settings
                        'mode' => CaptchaExtendedAction::MODE_MATH,
                    ),
                );
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'postOnly + delete',
                );
        }

        public function actionIndex()
        {
                //MemberNetwork::model()->updateNetwork(11, 10);
                $this->pageTitle = Lang::t('Register');
                //member model
                $member_model = new Member();
                $member_model_class_name = $member_model->getClassName();
                //user model
                $user_model = new Users(Users::SCENARIO_SIGNUP);
                $user_model->activation_code = Common::generateHash(microtime());
                $user_model->user_level = UserLevels::LEVEL_MEMBER;
                $user_model->timezone = SettingsTimezone::DEFAULT_TIME_ZONE;
                $user_model_class_name = $user_model->getClassName();
                //person model
                $person_model = new Person();
                $person_model_class_name = $person_model->getClassName();

                if (Yii::app()->request->isPostRequest) {
                        if (isset($_POST[$member_model_class_name])) {
                                $member_model->attributes = $_POST[$member_model_class_name];
                                $member_model->validate();
                        }
                        if (isset($_POST[$user_model_class_name])) {
                                $user_model->validatorList->add(CValidator::createValidator('CaptchaExtendedValidator', $user_model, 'verifyCode', array('allowEmpty' => !CCaptcha::checkRequirements())));
                                $user_model->attributes = $_POST[$user_model_class_name];
                                $user_model->validate();
                        }
                        if (isset($_POST[$person_model_class_name])) {
                                $person_model->attributes = $_POST[$person_model_class_name];
                                $person_model->validate();
                        }
                        if (!$member_model->hasErrors() && !$user_model->hasErrors() && !$person_model->hasErrors()) {
                                if ($user_model->save(FALSE)) {
                                        $person_model->id = $user_model->id;
                                        $person_model->save(FALSE);
                                        $member_model->id = $user_model->id;
                                        $member_model->save(FALSE);
                                        Yii::app()->user->setFlash('success', Lang::t('Check your email for account activation email.'));
                                        $this->refresh();
                                }
                        }
                }

                $this->render('index', array(
                    'member_model' => $member_model,
                    'user_model' => $user_model,
                    'person_model' => $person_model,
                ));
        }

}
