<?php

/**
 * Settings default controller
 * @author Fred <mconyango@gmail.com>
 */
class DefaultController extends SettingsModuleController {

        public function init()
        {
                parent::init();
                $this->resourceLabel = Lang::t('Settings');
                $this->resource = UserResources::RES_SETTINGS_GENERAL;
                $this->activeMenu = self::MENU_SETTINGS_GENERAL;
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                );
        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
                return array(
                    array('allow',
                        'actions' => array('index', 'runtime', 'socialmedia', 'email', 'security', 'payment'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        public function actionIndex()
        {
                $this->resource = UserResources::RES_SETTINGS_GENERAL;
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->showPageTitle = TRUE;
                $this->pageTitle = 'General ' . $this->resourceLabel;
                $this->activeMenu = self::MENU_SETTINGS_GENERAL;

                if (isset($_POST['settings'])) {
                        $this->hasPrivilege(Acl::ACTION_UPDATE);

                        foreach ($_POST['settings'] as $key => $value) {
                                if (!empty($value))
                                        Yii::app()->settings->set(Constants::CATEGORY_GENERAL, $key, $value);
                        }

                        Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                        $this->refresh();
                }

                $settings = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, array(
                    Constants::KEY_ADMIN_EMAIL,
                    Constants::KEY_COMPANY_NAME,
                    Constants::KEY_COMPANY_EMAIL,
                    Constants::KEY_CURRENCY,
                    Constants::KEY_PAGINATION,
                    Constants::KEY_SITE_NAME,
                    Constants::KEY_SITE_KEYWORDS,
                    Constants::KEY_SITE_DESCRIPTION,
                    Constants::KEY_DEFAULT_TIMEZONE,
                ));

                $this->render('index', array(
                    'settings' => $settings,
                ));
        }

        public function actionSocialmedia()
        {
                $this->resource = UserResources::RES_SOCIALMEDIA_SETTINGS;
                $this->hasPrivilege(Acl::ACTION_VIEW);

                $this->pageTitle = 'Social media ' . $this->resourceLabel;
                $this->activeMenu = self::MENU_SOCIALMEDIA_SETTINGS;

                if (isset($_POST['settings'])) {
                        $this->hasPrivilege(Acl::ACTION_UPDATE);

                        foreach ($_POST['settings'] as $key => $value) {
                                if (!empty($value))
                                        Yii::app()->settings->set(Constants::CATEGORY_SOCIAL_MEDIA, $key, $value);
                        }

                        Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                        $this->refresh();
                }

                $settings = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, array(
                    Constants::KEY_SM_FACEBOOK_PAGE,
                    Constants::KEY_SM_TWITTER_PAGE,
                    Constants::KEY_SM_LINKEDIN_PAGE,
                    Constants::KEY_SM_GOOGLEPLUS_PAGE,
                    Constants::KEY_SM_YOUTUBE_PAGE,
                ));

                $this->render('socialmedia', array(
                    'settings' => $settings,
                ));
        }

        public function actionRuntime()
        {
                $this->resource = UserResources::RES_SETTINGS_RUNTIME;
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->pageTitle = Lang::t('System runtime logs');
                $this->activeMenu = self::MENU_SETTINGS_RUNTIME;
                $this->showPageTitle = TRUE;

                $log_file = '';
                if (isset($_POST['log_file'])) {
                        $log_file = $_POST['log_file'];
                }

                $base_path = Yii::getPathOfAlias('application.runtime') . DS;
                if (empty($log_file))
                        $log_file = $base_path . 'application.log';

                if (isset($_POST['clear'])) {
                        $this->hasPrivilege(Acl::ACTION_DELETE);
                        if (file_exists($log_file)) {
                                @unlink($log_file);
                        }
                }

                $log_files = Common::getDirectoryFiles($base_path . 'application.log*');

                $this->render('runtime', array(
                    'log_files' => $log_files,
                    'log_file' => $log_file,
                ));
        }

        public function actionEmail()
        {
                $this->resource = UserResources::RES_SETTINGS_EMAIL;
                $this->hasPrivilege(Acl::ACTION_VIEW);
                $this->showPageTitle = FALSE;
                $this->activeTab = 1;
                $this->activeMenu = self::MENU_SETTINGS_EMAIL;
                $this->pageTitle = 'Email ' . $this->resourceLabel;

                if (isset($_POST['settings'])) {
                        $this->hasPrivilege(Acl::ACTION_UPDATE);
                        foreach ($_POST['settings'] as $key => $value) {
                                Yii::app()->settings->set(Constants::CATEGORY_EMAIL, $key, $value);
                        }

                        Yii::app()->user->setFlash('success', Lang::t('SUCCESS_MESSAGE'));
                        $this->refresh();
                }
                $settings = Yii::app()->settings->get(Constants::CATEGORY_EMAIL, array(
                    Constants::KEY_EMAIL_MAILER,
                    Constants::KEY_EMAIL_HOST,
                    Constants::KEY_EMAIL_PORT,
                    Constants::KEY_EMAIL_USERNAME,
                    Constants::KEY_EMAIL_PASSWORD,
                    Constants::KEY_EMAIL_SECURITY,
                    Constants::KEY_EMAIL_MASTER_THEME,
                    Constants::KEY_EMAIL_SENDMAIL_COMMAND,
                ));

                $this->render('email', array(
                    'settings' => $settings,
                ));
        }

}

