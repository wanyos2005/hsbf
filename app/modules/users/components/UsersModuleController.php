<?php

/**
 * @author Fred <mconyango@gmail.com>
 * Parent controller for the users module
 */
class UsersModuleController extends AdminModuleController {

        const MENU_USER_ADMIN = 'ADMINUSERS';
        const MENU_USER_ROLES = 'USER_ROLES';
        const MENU_USER_LEVELS = 'USER_LEVELS';
        const MENU_USER_RESOURCES = 'USER_RESOURCES';

        public function init()
        {
                parent::init();
        }

}
