<?php

/**
 * This class is mainly used for defining system constants that is not associated to any particular model
 * @author Fred <mconyango@gmail.com>
 */
class Constants {

        //general settings keys

        const CATEGORY_GENERAL = 'general';
        const KEY_MAINTENACE_MODE = 'maintenance_mode';
        const KEY_ADMIN_EMAIL = 'admin_email';
        const KEY_COMPANY_NAME = 'company_name';
        const KEY_COMPANY_EMAIL = 'company_email';
        const KEY_CURRENCY = 'currency';
        const KEY_PAGINATION = 'pagination';
        const KEY_SITE_NAME = 'site_name';
        const KEY_COMPANY_ADDRESS = 'company_address';
        const KEY_SITE_KEYWORDS = 'site_keywords';
        const KEY_SITE_DESCRIPTION = 'site_description';
        const KEY_DEFAULT_TIMEZONE = 'default_timezone';
        //social media
        const CATEGORY_SOCIAL_MEDIA = 'social_media';
        const KEY_SM_FACEBOOK_PAGE = 'sm_facebook_page';
        const KEY_SM_TWITTER_PAGE = 'sm_twitter_page';
        const KEY_SM_LINKEDIN_PAGE = 'sm_linkedin_page';
        const KEY_SM_GOOGLEPLUS_PAGE = 'sm_googleplus_page';
        const KEY_SM_YOUTUBE_PAGE = 'sm_youtube_page';
        //sms category
        const CATEGORY_SMS = 'sms';
        const KEY_SMS_ROUTE = 'sms_route';
        const KEY_SMS_COUNTRY_CODE = 'country_code';
        const KEY_SMS_AFRICASTALKING_USERNAME = 'africastalking_username';
        const KEY_SMS_AFRICASTALKING_PASSWORD = 'africastalking_password';
        const KEY_SMS_AFRICASTALKING_API_KEY = 'africastalking_api_key';
        const KEY_SMS_AFRICASTALKING_SHORTCORD = 'africastalking_shortcode';
        const KEY_SMS_SENDER_ID = 'sender_id';
        const KEY_SMS_INFOBIP_USERNAME = 'infobip_username';
        const KEY_SMS_INFOBIP_PASSWORD = 'infobip_password';
        //advanced settings
        const CATEGORY_ADVANCED = 'advanced';
        const KEY_PHP_PATH = 'PHP_PATH';
        const KEY_JOBS_LOG_FILE = 'JOBS_LOG_FILE';
        //email settings
        const CATEGORY_EMAIL = 'email';
        const KEY_EMAIL_MAILER = 'email_mailer';
        const KEY_EMAIL_HOST = 'email_host';
        const KEY_EMAIL_PORT = 'email_port';
        const KEY_EMAIL_USERNAME = 'email_username';
        const KEY_EMAIL_PASSWORD = 'email_password';
        const KEY_EMAIL_SECURITY = 'email_security';
        const KEY_EMAIL_MASTER_THEME = 'email_master_theme';
        const KEY_EMAIL_SENDMAIL_COMMAND = 'email_sendmail_command';
        //survey constants
        const CATEGORY_SURVEY = 'survey';
        const KEY_SURVEY_LANG_SELECTION = 'lang_selection';
        //active record constants
        const LABEL_CREATE = 'Add';
        const LABEL_UPDATE = 'Edit';
        const LABEL_DELETE = 'Delete';
        const LABEL_VIEW = 'View details';
        //miscelleneous constants
        const SPACE = ' ';
        //queue manager
        const CATEGORY_QUEUEMANAGER = 'queuemanager';
        const KEY_QUEUEMANAGER_STATUS = 'queuemanager_status';

}
