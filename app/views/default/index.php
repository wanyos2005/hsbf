<?php

if (Yii::app()->user->getState(UserIdentity::STATE_USER_LEVEL) == 'DEFAULT')
    $this->renderPartial('application.views.layouts.partials._membersStats');
?>
