<div class="login-container" style="margin-top: 50px;">
    <div class="space-6"></div>
    <div class="position-relative">
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header blue lighter bigger">
                        <i class="icon-key"></i>
                        <?php echo CHtml::encode($this->pageTitle); ?>
                    </h4>
                    <div class="space-6"></div>
                    <p>Enter your username or email to receive instructions</p>
                    <?php $this->renderPartial('application.views.widgets._alert') ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'forgot-password-form',
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
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Username or Email')); ?>
                                <i class="icon-envelope"></i>
                            </span>
                        </label>
                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary"><i class="icon-lightbulb"></i>Send Me!</button>
                        </div>
                    </fieldset>
                    <?php $this->endWidget(); ?>
                </div><!-- /widget-main -->
                <div class="toolbar clearfix">
                    <div><a href="<?php echo $this->createUrl('login') ?>" class="forgot-password-link">Back to login <i class="icon-arrow-right"></i></a></div>
                </div>
            </div><!-- /widget-body -->
        </div><!-- /login-box -->
    </div><!-- /position-relative -->
</div>