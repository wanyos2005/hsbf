<?php

/**
 * Handles most common ACL db operations
 * @author Fredrick <mconyango@gmail.com>
 */
class Acl {

        //define actions

        const ACTION_VIEW = 'view';
        const ACTION_CREATE = 'create';
        const ACTION_UPDATE = 'update';
        const ACTION_DELETE = 'delete';

        /**
         * Gets system-wide privileges of a user;
         * @param type $user_id
         */
        public static function getPrivileges($user_id = NULL)
        {
                /*
                 * 1. get all the resources
                 * 2. get user_type & role
                 * 3. for each resources check whether it is forbidden
                 * 4.If user type =system_engineer or super_admin return true
                 * 5.Check if the role has privilege
                 */
                if (empty($user_id))
                        $user_id = Yii::app()->user->id;
                //get all resources
                $resources = UserResources::model()->getResources();
                $user_model = Users::model()->loadModel($user_id);
                $forbidden_resources = self::getForbiddenResources($user_model->user_level);
                $role_on_resources = UserRolesOnResources::model()->getData('*', '`role_id`=:t1', array(':t1' => $user_model->role_id));
                return self::check($resources, $user_model, $forbidden_resources, $role_on_resources);
        }

        private static function check($resources, $user, $forbidden, $role_on_resources)
        {
                $privileges = array();
                //check whether the action is valid
                $action = array(
                    self::ACTION_VIEW,
                    self::ACTION_CREATE,
                    self::ACTION_UPDATE,
                    self::ACTION_DELETE,
                );
                foreach ($resources as $row) {
                        $resource = $row['id'];
                        $role_on_resource = self::seachRoleOnResources($role_on_resources, $resource);
                        $privilege = array();
                        foreach ($action as $act) {
                                $passed = self::isActionValid($row, $act);
                                if (!$passed) {
                                        $privilege[$act] = 0;
                                        continue;
                                }
                                //check forbidden resource
                                if (in_array($resource, $forbidden)) {
                                        $privilege[$act] = 0;
                                        continue;
                                }
                                //system engineer,super admin  access everything else
                                if ($user->user_level === UserLevels::LEVEL_ENGINEER || $user->user_level === UserLevels::LEVEL_SUPERADMIN) {
                                        $privilege[$act] = 1;
                                        continue;
                                }
                                //whatever a user accesses now is based on the user's roles (applies admin user type)
                                if (empty($role_on_resource)) {
                                        $privilege[$act] = 0;
                                        continue;
                                }
                                if ($role_on_resource[0][$act] == 0) {
                                        $privilege[$act] = 0;
                                        continue;
                                }
                                $privilege[$act] = 1;
                        }
                        $privileges[$resource] = $privilege;
                }
                return $privileges;
        }

        private static function seachRoleOnResources($array, $value, $key = 'resource_id')
        {
                $results = array();
                if (is_array($array)) {
                        if (isset($array[$key]) && $array[$key] == $value)
                                $results[] = $array;
                        foreach ($array as $subarray)
                                $results = array_merge($results, self::seachRoleOnResources($subarray, $value, $key));
                }
                return $results;
        }

        /**
         * This function checks whether a given admin user has a specified privilege on a specified resource
         * @param array $privileges
         * @param int $resource_id: name of the resource
         * @param int $action : privilege e.g {view,create,update,delete}
         * @param int $throw_exception. whether to throw exception or not: True throw exception
         * @return boolean True if the user has Privilege else false
         */
        public static function hasPrivilege($privileges, $resource_id, $action, $throw_exception = true)
        {
                if (!isset($privileges[$resource_id][$action]) || !$privileges[$resource_id][$action])
                        return self::enforceAcl($throw_exception);
                return TRUE;
        }

        protected static function enforceAcl($throw_exception)
        {
                if ($throw_exception)
                        throw new CHttpException(403, Lang::t('403_error'));
                return FALSE;
        }

        /**
         * get the forbidden resources for a given user type
         * @param type $user_level
         * @return type
         * @throws CHttpException
         */
        public static function getForbiddenResources($user_level)
        {
                $model = UserLevels::model()->loadModel($user_level);
                if ($model === NULL)
                        throw new CHttpException(500, 'wrong user type');
                $bannedResources = explode(',', $model->banned_resources);
                if (!empty($model->banned_resources_inheritance))
                        $bannedResources = array_merge($bannedResources, self::getForbiddenResources($model->banned_resources_inheritance));
                return $bannedResources;
        }

        /**
         * check whether the given action is valid on a given resource
         * @param type $resource
         * @param type $action
         * @return type
         * @throws CHttpException
         */
        public static function isActionValid($resource, $action)
        {
                switch ($action) {
                        case self::ACTION_VIEW:
                                return $resource['viewable'];
                        case self::ACTION_CREATE:
                                return $resource['createable'];
                        case self::ACTION_UPDATE:
                                return $resource['updateable'];
                        case self::ACTION_DELETE:
                                return $resource['deleteable'];
                        default :
                                throw new CHttpException(500, 'wrong action');
                }
        }

}
