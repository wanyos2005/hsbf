<div class="login-container">
        <div class="center">
                <h1><span class="white"><?php echo $this->settings[Constants::KEY_SITE_NAME] ?></span></h1>
        </div>
        <div class="space-6"></div>
        <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                        <div class="widget-body">
                                <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                                <i class="icon-coffee green"></i>
                                                <?php echo CHtml::encode($this->pageTitle); ?>
                                        </h4>
                                        <div class="space-6"></div>
                                        <?php $this->renderPartial('application.views.widgets._alert') ?>
                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'users-form',
                                            'enableClientValidation' => false,
                                            'clientOptions' => array(
                                                'validateOnSubmit' => false,
                                            ),
                                            'htmlOptions' => array(
                                                'class' => '',
                                            )
                                        ));
                                        ?>
                                        <fieldset>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activeTextField($person_model, 'first_name', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('first_name'))); ?>
                                                                <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($person_model, 'first_name') ?>
                                                </label>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activeTextField($person_model, 'last_name', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('last_name'))); ?>
                                                                <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($person_model, 'last_name') ?>
                                                </label>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activeEmailField($user_model, 'email', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('email'))); ?>
                                                                <i class="icon-envelope"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'email') ?>
                                                </label>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activeTextField($user_model, 'username', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('username'))); ?>
                                                                <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'username') ?>
                                                </label>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activePasswordField($user_model, 'password', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('password'))); ?>
                                                                <i class="icon-lock"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'password') ?>
                                                </label>
                                                <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                                <?php echo CHtml::activePasswordField($user_model, 'confirm', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('confirm'))); ?>
                                                                <i class="icon-lock"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'confirm') ?>
                                                </label>
                                                <labe class="block clearfix">
                                                        <?php if (CCaptcha::checkRequirements()): ?>
                                                                <span class="block">
                                                                        <?php $this->widget('CCaptcha'); ?>
                                                                        <?php echo $form->textField($user_model, 'verifyCode', array()); ?>
                                                                        <p class="help-block"><?php echo Lang::t('Solve the maths problem. (verify that you are human)') ?></p>
                                                                </span>
                                                                <?php echo $form->error($user_model, 'verifyCode'); ?>
                                                        <?php endif; ?>
                                                </labe>
                                                <div class="space"></div>
                                                <div class="clearfix">
                                                        <button type="submit" class="btn btn-sm btn-success btn-block">
                                                                <?php echo Lang::t('Register') ?>
                                                                <i class="icon-arrow-right icon-on-right"></i>
                                                        </button>
                                                </div>
                                                <div class="space-4"></div>
                                        </fieldset>
                                        <?php $this->endWidget(); ?>
                                </div><!-- /widget-main -->
                                <div class="toolbar clearfix">
                                        <div>
                                                <a class="user-signup-link" href="<?php echo Yii::app()->createUrl('auth/default/login') ?>">
                                                        <?php echo Lang::t('Login') ?>
                                                </a>
                                        </div>
                                </div>
                        </div><!-- /widget-body -->
                </div><!-- /login-box -->
        </div><!-- /position-relative -->
</div>