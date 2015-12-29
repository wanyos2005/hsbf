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
?>
<?php $this->renderPartial('application.modules.users.views.default.tab', array('model' => $user_model, 'title' => $title)); ?>
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
    </div>
    <div id="render" class="col-xs-12 col-sm-9">
        <?php $this->renderPartial($render, array('model' => $model, 'others' => $others, 'user' => $user_model)); ?>
    </div>
</div>