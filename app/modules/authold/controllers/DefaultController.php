<?php

/**
 *
 * @author Fred<mconyango@gmail.com>
 */
class DefaultController extends AuthModuleController {

        public function init()
        {
                parent::init();
        }

        public function actionLogin()
        {
                //if (!Yii::app()->user->isGuest)
                       // $this->redirect(array('default/index'));

                $this->pageTitle = 'Login page';

                $model = new LoginForm;
                $model_class_name = get_class($model);

                // collect user input data
                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        $model->_identity = new UserIdentity($model->username, $model->password);
                        $model->_identity->user = Users::model()->find('`username`=:t1 OR `email`=:t1', array(':t1' => $model->username));
                        if ($model->validate()) {
                                if ($model->_identity->login($model->rememberMe)) {
                                        if (Controller::$user_level !== UserLevels::LEVEL_MEMBER)
                                                $this->redirect(Yii::app()->getModule('admin')->user->returnUrl);
                                        $this->redirect(Yii::app()->user->returnUrl);
                                }
                        }
                }

                $this->render('login', array(
                    'model' => $model,
                ));
        }

        public function actionActivate($id, $token)
        {
                $model = Users::model()->loadModel($id);
                if ($model->activation_code !== $token)
                        throw new CHttpException(403, Lang::t('403_error'));

                $model->status = Users::STATUS_ACTIVE;
                $model->activation_code = null;
                $model->save(FALSE);

                Yii::app()->user->setFlash('success', 'You have successfully activated your account. You may now sign in to your account.');
                //redirect to login page
                $this->redirect(array('login'));
        }

        public function actionLogout()
        {
                Yii::app()->user->logout();
                $this->redirect(Yii::app()->homeUrl);
        }

        public function actionForgotPassword()
        {
                $this->pageTitle = 'Password Recovery';

                $model = new ForgotPasswordForm();
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->validate()) {
                                Yii::app()->user->setFlash('success', $model->success_message);
                                $this->refresh();
                        }
                }

                $this->render('forgotPassword', array(
                    'model' => $model,
                ));
        }

        /**
         * User enters a new password
         * @param type $id
         * @param type $token
         * @throws CHttpException
         */
        public function actionResetPassword($id, $token)
        {
                $this->pageTitle = 'New Password';
                $model = Users::model()->loadModel($id);

                if ($model->password_reset_code !== $token)
                        throw new CHttpException(400, Lang::t('400_error'));

                $model->password_reset_code = null;
                $model->password_reset_date = date('Y-m-d H:i:s');
                $model->setScenario(Users::SCENARIO_RESET_PASSWORD);
                $model->password = NULL;
                $model->send_email = FALSE;
                $model_class_name = $model->getClassName();

                if (isset($_POST[$model_class_name])) {
                        $model->attributes = $_POST[$model_class_name];
                        if ($model->validate(array('password', 'confirm'))) {
                                $model->save(false);
                                Yii::app()->user->setFlash('success', Lang::t('Success. Please use your new password to sign in'));
                                $this->redirect(array('login'));
                        }
                }

                $this->render('resetPassword', array(
                    'model' => $model,
                ));
        }

}
