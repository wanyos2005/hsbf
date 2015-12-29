<?php
if ($this->showLink(UserResources::RES_USER_ADMIN)):
    $this->breadcrumbs = array(
        Lang::t(Common::pluralize($this->resourceLabel)) => array('index'),
        $user_model->username,
    );
else:
    $this->breadcrumbs = array(
        $user_model->username,
    );
endif;

$can_update = $user_model->canBeModified($this, Acl::ACTION_UPDATE);
$can_view_activity = $this->showLink(UserResources::RES_USER_ACTIVITY);
?>
<?php $this->renderPartial('application.modules.users.views.default._profile_tabs', array('model' => $user_model)); ?>
<div id="user-profile-1" class="user-profile row">
    <div class="col-xs-12 col-sm-3 center">
        <div>
            <span class="profile-picture">
                <?php echo CHtml::image(MyYiiUtils::getThumbSrc($person_model->getProfileImagePath(), array('resize' => array('width' => 200, 'height' => 200))), CHtml::encode($user_model->username), array('id' => 'avator', 'class' => 'editable img-responsive')); ?>
            </span>
            <div class="space-4"></div>
            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">
                    <a href="javascript:void(0);" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-circle <?php echo $user_model->status === Users::STATUS_ACTIVE ? 'light-green' : ($user_model->status === Users::STATUS_PENDING ? 'yellow' : 'red') ?> middle"></i>
                        &nbsp;
                        <span class="white"><?php echo CHtml::encode($person_model->name) ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="profile-contact-info">
            <div class="profile-contact-links align-left">
                <ul class="list-unstyled">
                    <?php if (Users::isMyAccount($user_model->id)): ?>
                        <li><a class="btn btn-link" href="<?php echo $this->createUrl('view', array('id' => $user_model->id, 'action' => Users::ACTION_CHANGE_PASSWORD)) ?>"><i class="fa fa-asterisk bigger-120 green"></i> <?php echo Lang::t('Change your password') ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="space-4"></div>
            <div class="width-80 label">
                <div class="inline position-relative">
                    <a href="<?php echo $this->createUrl('printMembershipDetails', array('id' => $user_model->id)); ?>" target="_blank">
                        <span class="white">Print Membership Details</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <?php if (empty($action)): ?>
            <div class="panel-group" id="accordion"  style="height: 400px; overflow-y:scroll">
                 <?php $this->renderPartial('_view_personal', array('model' => $person_model, 'can_update' => $can_update)) ?>
                <?php $this->renderPartial('_view_address', array('model' => $address_model, 'can_update' => $can_update)) ?>

                <?php
                if ($person_model->married == 'y')
                    $this->renderPartial('_view_spouse', array('spouse' => $spouse, 'buttons' => DependentMembers::model(), 'model' => $person_model, 'can_update' => $can_update));
                ?>
                <?php
                if ($person_model->havechildren == 'y')
                    $this->renderPartial('_view_children', array('child' => $child, 'buttons' => DependentMembers::model(), 'model' => $person_model, 'can_update' => $can_update));
                ?>

                <?php if (!empty($child) || !empty($spouse) || !empty($prnts) || !empty($siblings)): ?>
                    <?php $this->renderPartial('_view_nextOfKin', array('nextOfKins' => $nextOfKins, 'buttons' => KinsAndNominees::model(), 'model' => $person_model, 'can_update' => $can_update)); ?>
                   
                    <?php $this->renderPartial('_view_nominees', array('nominees' => $nominees, 'buttons' => KinsAndNominees::model(), 'model' => $person_model, 'can_update' => $can_update)); ?>
                <?php endif; ?>
                <?php $this->renderPartial('_view_parents', array('prnts' => $prnts, 'buttons' => DependentMembers::model(), 'model' => $person_model, 'can_update' => $can_update)); ?>
                <?php
                if ($person_model->married == 'y')
                    $this->renderPartial('_view_parents', array('inlaws' => $inlaws, 'buttons' => DependentMembers::model(), 'model' => $person_model, 'can_update' => $can_update));
                ?>
                <?php $this->renderPartial('_view_siblings', array('siblings' => $siblings, 'buttons' => DependentMembers::model(), 'model' => $person_model, 'can_update' => $can_update)); ?>
           
                 <?php //$this->renderPartial('_view_account', array('model' => $user_model, 'can_update' => $can_update)) ?>
            </div>
        <?php elseif ($action === Users::ACTION_UPDATE_PERSONAL): ?>
            <?php $this->renderPartial('_update_personal', array('model' => $person_model)) ?>
        <?php elseif ($action === Users::ACTION_UPDATE_ACCOUNT): ?>
            <?php $this->renderPartial('_update_account', array('model' => $user_model)) ?>
        <?php elseif ($action === Users::ACTION_UPDATE_ADDRESS): ?>
            <?php $this->renderPartial('_update_address', array('model' => $address_model)) ?>
        <?php elseif ($action === Users::ACTION_RESET_PASSWORD): ?>
            <?php $this->renderPartial('_reset_password', array('model' => $user_model)) ?>
        <?php elseif ($action === Users::ACTION_CHANGE_PASSWORD): ?>
            <?php $this->renderPartial('_change_password', array('model' => $user_model)) ?>
        <?php elseif ($action === Users::ACTION_ADD_DEPENDENTS): ?>
            <?php $this->renderPartial($render, array('models' => $models, 'jamaa' => $jamaa)) ?>
        <?php elseif ($action === KinsAndNominees::NEXT_OF_KIN || $action === KinsAndNominees::NOMINEE): ?>
            <?php $this->renderPartial($render, array('models' => $models, 'jamaa' => $jamaa)) ?>
        <?php endif; ?>

               
    </div>
</div>
<?php Yii::app()->clientScript->registerScript('users_' . $user_model->id, "MyController.Users.User.init();"); ?>