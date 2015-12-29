<div class="login-container">
    <div class="center">
        <h3><span class="white"><?php echo $this->settings[Constants::KEY_SITE_NAME] ?></span></h3>
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
                        'id' => 'login-form',
                        'enableClientValidation' => false,
                        'focus' => array($model, 'username'),
                        'clientOptions' => array(
                            'validateOnSubmit' => false,
                        ),
                        'htmlOptions' => array(
                            'class' => '',
                        )
                    ));
                    ?>
                    <?php echo $form->errorSummary($model, ''); ?>
                    <fieldset>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('username'))); ?>
                                <i class="icon-user"></i>
                            </span>
                        </label>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('password'))); ?>
                                <i class="icon-lock"></i>
                            </span>
                        </label>
                        <div class="space"></div>
                        <div class="clearfix">
                            <label class="inline">
                                <?php echo $form->checkBox($model, 'rememberMe', array('class' => 'ace')) ?>
                                <span class="lbl"> Remember Me</span>
                            </label>
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary"><i class="icon-key"></i>Login</button>
                        </div>
                        <div class="space-4"></div>
                    </fieldset>
                    <?php $this->endWidget(); ?>
                </div><!-- /widget-main -->
                <div class="toolbar clearfix">

                    <div><a href="<?php echo $this->createUrl('forgotPassword')   ?>" class="forgot-password-link">Forgot Password</a></div>
                    <div>
                        <a href="<?php echo Yii::app()->createUrl('auth/register/index') ?>" class="user-signup-link">
                            <?php echo Lang::t('Register') ?>
                            <i class="icon-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div><!-- /widget-body -->
        </div><!-- /login-box -->
    </div><!-- /position-relative -->
</div>