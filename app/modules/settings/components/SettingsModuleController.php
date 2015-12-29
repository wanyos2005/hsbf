<?php

/**
 * @author Fred <mconyango@gmail.com>
 * Parent controller for the settings module
 */
class SettingsModuleController extends AdminModuleController {

        const MENU_SETTINGS_PAGE = 'SETTINGS_PAGE';
        const MENU_SETTINGS_STATIC_SECTIONS = 'SETTINGS_STATIC_SECTIONS';
        const MENU_SETTINGS_GENERAL = 'SETTINGS_GENERAL';
        const MENU_SETTINGS_EMAIL = 'SETTINGS_EMAIL';
        const MENU_SETTINGS_RUNTIME = 'SETTINGS_RUNTIME';
        const MENU_SETTINGS_TOWN = 'SETTINGS_TOWN';
        const MENU_SETTINGS_UNITS_OF_MEASURE = 'SETTINGS_UNITS_OF_MEASURE';
        const MENU_SETTINGS_TAXES = 'SETTINGS_TAXES';
        const MENU_SETTINGS_CRON = 'SETTINGS_CRON';
        const MENU_MODULES_ENABLED = 'MODULES_ENABLED';

        public function init()
        {
                parent::init();
        }

}
