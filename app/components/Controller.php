<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    const GET_PARAM_RETURN_URL = 'r_url';

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * Stores commonly used system settings
     * @uses {@link CmsSettings}
     * @var array
     */
    public $settings = array();

    /**
     *
     * @var type
     */
    public $activeTab = 1;

    /**
     *
     * @var type
     */
    public $activeMenu = 1;

    /**
     *
     * @var type
     */
    public $package = array();

    /**
     *
     * @var type
     */
    public $package_id = 'mlm';

    /**
     * The module's published assets base url
     * @var type
     */
    public $package_base_url;

    /**
     * The base title for a controller
     * @var type
     */
    public $resourceLabel;

    /**
     * Page description if any
     * @var type
     */
    public $pageDescription = '';

    /**
     * Used to control the display of page title
     * @var type
     */
    public $showPageTitle = TRUE;

    /**
     * Home module for the logged in user.
     * For admin users = "admin", for members=NULL
     * @var type
     */
    public $home_url;

    /**
     * Stores the user's privileges
     * @var type
     */
    public $privileges;

    /**
     *
     * @var type
     */
    public $resource;

    /**
     * Stores the cookie value of collapsed status of the sidebar
     * @var type
     */
    public $sidebar_collapsed = false;

    /**
     * Stores the user level of the logged in user
     * @var type
     */
    public static $user_level;

    /**
     * dept id of the logged in user
     * @var type
     */
    public static $dept_id;

    public function init() {
        parent::init();

        $this->registerPackage();
        $this->setSettings();

        //default title
        if (!empty($this->resourceLabel))
            $this->pageTitle = Lang::t($this->resourceLabel);
        //form error css
        CHtml::$errorCss = 'my-form-error';
        CHtml::$errorSummaryCss = 'alert alert-block alert-danger';
        if (!Yii::app()->user->isGuest) {
            $home_module = Yii::app()->user->getState(UserIdentity::STATE_HOME_MODULE);
            $this->home_url = !empty($home_module) ? Yii::app()->createUrl($home_module . '/default/index') : Yii::app()->createUrl('default/index');
            self::$user_level = Yii::app()->user->getState(UserIdentity::STATE_USER_LEVEL);
            self::$dept_id = Yii::app()->user->getState(UserIdentity::STATE_DEPT_ID);
        }
        $this->setPrivileges();

        //get the sidebar collapsed status from cookie
        $sidebar_collapsed = Yii::app()->request->cookies['mlm_ace_settings_sidebar-collapsed'];
        if ($sidebar_collapsed !== NULL)
            $this->sidebar_collapsed = $sidebar_collapsed->value;
    }

    public function registerPackage() {
        $this->setPackage();

        $clientScript = Yii::app()->getClientScript();
        $this->package_base_url = $clientScript
                ->addPackage($this->package_id, $this->package)
                ->registerPackage($this->package_id)
                ->getPackageBaseUrl($this->package_id);
    }

    public function getPackageBaseUrl() {
        return $this->package_base_url;
    }

    public function setPackage() {
        //register commonly used assets.
        $this->package = array(
            'baseUrl' => Yii::app()->theme->baseUrl,
            'js' => array(
                'js/jquery.cookie-min.js',
                'js/bootstrap.min.js',
                'js/jquery-ui-1.10.3.custom.min.js',
                'js/jquery.ui.touch-punch.min.js',
                'plugins/jquery.slimscroll.min.js',
                'plugins/jquery.sparkline.min.js',
                'js/my-utils.js',
                'js/ace-settings-min.js',
                'js/ace-elements.min.js',
                'js/ace-min.js',
                'plugins/blockui/jquery.blockUI.min.js',
                'plugins/colorbox/jquery.colorbox-min.js',
                'plugins/typeahead/typeahead-bs2.min.js',
                'plugins/date-time/jquery.timeago.min.js',
                'js/controller.js',
                'js/app.js',
            ),
            'css' => array(
                'css/bootstrap.min.css',
                'css/font-awesome.min.css',
                'css/ace-fonts.css', //remove if using google fonts
                'css/ace.min.css',
                'css/ace-skins.min.css',
                'plugins/font-awesome/css/font-awesome.min.css',
                'plugins/colorbox/colorbox.css',
                'css/custom.css',
            )
        );
    }

    public function setSettings() {
        if (YII_DEBUG)
            Yii::app()->settings->deleteCache(Constants::CATEGORY_GENERAL);

        //get some commonly used settings
        $this->settings = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, array(
            Constants::KEY_COMPANY_NAME => 'Chimes LTD',
            Constants::KEY_SITE_NAME => Yii::app()->name,
            Constants::KEY_CURRENCY => 'KES',
            Constants::KEY_PAGINATION => 10,
        ));
    }

    /**
     * Returns the module of the current controller
     * @return mixed module name or false if the controller does not belong to a module
     */
    public function getModuleName() {
        $module = $this->getModule();
        if ($module !== null)
            return $module->getName();
        return FALSE;
    }

    protected function setPrivileges() {
        //get the user's privileges only when a user is logged in
        if (!Yii::app()->user->isGuest) {
            if (!YII_DEBUG) {
                // keep the value in cache for at most (60*60 sec) 1 hr
                $id = md5(Yii::app()->user->id . '_privileges');
                $this->privileges = Yii::app()->cache->get($id);
                if ($this->privileges === FALSE) {
                    $this->privileges = Acl::getPrivileges();
                    Yii::app()->cache->set($id, $this->privileges, 60);
                }
            } else
                $this->privileges = Acl::getPrivileges();
        }
    }

    /**
     * Whether to show link or not
     * @param string $resource
     * @param string $action default to "view"
     * @return boolean  True or False
     */
    public function showLink($resource = null, $action = null) {
        if ($resource === null)
            $resource = $this->resource;

        if ($action === NULL)
            $action = Acl::ACTION_VIEW;
        return Acl::hasPrivilege($this->privileges, $resource, $action, FALSE);
    }

    /**
     * Should be called before any action the require ACL
     * @param string $action
     */
    public function hasPrivilege($action = NULL) {
        if (NULL === $action)
            $action = Acl::ACTION_VIEW;
        Acl::hasPrivilege($this->privileges, $this->resource, $action);
    }

    /**
     * Check if module is enabled
     * @param type $module_id
     * @return type
     */
    public static function isModuleEnabled($module_id) {
        return ModulesEnabled::model()->isModuleEnabled($module_id);
    }

    /**
     * Get return link
     * @param type $url
     * @return type
     */
    public static function getReturnUrl($url = NULL) {
        $rl = filter_input(INPUT_GET, self::GET_PARAM_RETURN_URL);
        return !empty($rl) ? $rl : $url;
    }

}
