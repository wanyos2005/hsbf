<?php

/**
 * Self registration
 * @author Fred <mconyango@gmail.com>
 */
class RegisterController extends AuthModuleController {

    public function init() {
        // register class paths for extension captcha extended
        Yii::$classMap = array_merge(Yii::$classMap, array(
            'CaptchaExtendedAction' => Yii::getPathOfAlias('ext.captcha') . DIRECTORY_SEPARATOR . 'CaptchaExtendedAction.php',
            'CaptchaExtendedValidator' => Yii::getPathOfAlias('ext.captcha') . DIRECTORY_SEPARATOR . 'CaptchaExtendedValidator.php'
        ));
        parent::init();
    }

    public function actions() {
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
    public function filters() {
        return array(
            'postOnly + delete',
        );
    }

    public function actionIndex() {
        $this->pageTitle = Lang::t('Register');

        $user_model = new Users(Users::SCENARIO_SIGNUP);
        $user_model->activation_code = Common::generateHash(microtime());
        $user_model->user_level = UserLevels::LEVEL_MEMBER;
        $user_model->timezone = SettingsTimezone::DEFAULT_TIME_ZONE;
        $user_model_class_name = $user_model->getClassName();

        $person_model = new Person();
        $person_model_class_name = $person_model->getClassName();

        $person_address = new PersonAddress();
        $person_address_class_name = $person_address->getClassName();

        if (Yii::app()->request->isPostRequest) {
            $verifyPhoneCode = isset($_POST['verifyPhoneCode']) ? $_POST['verifyPhoneCode'] : null;
            $verifyMailCode = isset($_POST['verifyMailCode']) ? $_POST['verifyMailCode'] : null;

            if (isset($_POST[$user_model_class_name])) {
                $user_model->validatorList->add(CValidator::createValidator('CaptchaExtendedValidator', $user_model, 'verifyCode', array('allowEmpty' => !CCaptcha::checkRequirements())));
                $user_model->attributes = $_POST[$user_model_class_name];
                $user_model->status = 'Active';
                $user_model->answer = strtoupper($user_model->answer);
                $user_model->validate();
            }
            if (isset($_POST[$person_model_class_name])) {
                $person_model->attributes = $_POST[$person_model_class_name];
                $person_model->married = 'n';
                $person_model->havechildren = 'n';
                $person_model->validate();
            }
            if (isset($_POST['PersonAddress'])) {
                $person_address->attributes = $_POST[$person_address_class_name];
                $person_address->validate(array('phone1'));
            }
            if (!$user_model->hasErrors() && !$person_model->hasErrors() && !$person_address->hasErrors())
                if ($user_model->save(FALSE)) {
                    $person_model->id = $user_model->id;
                    $person_model->save(FALSE);
                    $person_address->person_id = $person_model->id;
                    $person_address->save(FALSE);
                    Yii::app()->user->setFlash('success', Lang::t('Account created successfullly. Please enter your login details.'));
                    $this->redirect($this->createUrl('/users/default/view', array('id' => $user_model->id)));
                    //$this->redirect('../default/login');
                }
        }

        $this->render('index', array(
            'user_model' => $user_model,
            'person_model' => $person_model,
            'person_address' => $person_address,
            'verifyPhoneCode' => isset($verifyPhoneCode) ? $verifyPhoneCode : null,
            'verifyMailCode' => isset($verifyMailCode) ? $verifyMailCode : null
        ));
    }

}
