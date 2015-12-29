<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminModuleController extends Controller {
        //menu constants

        const MENU_DASHBOARD = 'DASHBOARD';
        const MENU_HELP = 'HELP';

        public function init()
        {
                parent::init();
                if (!Yii::app()->user->isGuest && Yii::app()->user->getState(UserIdentity::STATE_AUDIT_TRAIL) === UserLevels::LEVEL_MEMBER)
                        $this->redirect(Yii::app()->createUrl('default/index'));
                if (empty($this->activeMenu))
                        $this->activeMenu = self::MENU_DASHBOARD; //default active menu
        }

}

