<?php if (Yii::app()->user->isGuest): ?>
    <div class="login-container">
        <?php if (!isset($contribution)): ?>
            <div class="center">
                <h3><span class="white"><?php echo $this->settings[Constants::KEY_SITE_NAME] ?></span></h3>
            </div>
            <div class="space-6"></div>
        <?php endif; ?>
        <div class="position-relative">
            <div id="login-box" class="login-box visible widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header blue lighter bigger">
                            <i class="icon-coffee green"></i>
                            <?php echo CHtml::encode($this->pageTitle); ?>
                        </h4>
                        <div class="space-6"></div>
                    <?php endif; ?>


                    <?php $this->renderPartial('application.views.widgets._alert') ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'users-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array(
                            'class' => '',
                        )
                            )
                    );

                    echo CHtml::hiddenField('verifyPhoneCode', isset($verifyPhoneCode) && !empty($verifyPhoneCode) ? $verifyPhoneCode : null, array('id' => 'verifyPhoneCode'));
                    echo CHtml::hiddenField('verifyMailCode', isset($verifyMailCode) && !empty($verifyMailCode) ? $verifyMailCode : null, array('id' => 'verifyMailCode'));
                    ?>
                    <?php if (!Yii::app()->user->isGuest): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Register Another Member</h3></div>
                            <div class="panel-body">
                                <div class="col-md-8 col-sm-12" style="width: 100%">
                                    <div id="fomu" style="width: 100%">
                                    <?php endif; ?>

                                    <fieldset>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activeTextField($person_model, 'first_name', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('first_name'))); ?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($person_model, 'first_name') ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo $form->textField($person_model, 'middle_name', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('middle_name'))); ?>
                                                            <?php echo $form->error($person_model, 'middle_name'); ?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activeTextField($person_model, 'last_name', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('last_name'))); ?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($person_model, 'last_name') ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo $form->textField($person_model, 'idno', array('class' => 'form-control', 'required' => true, 'placeholder' => $person_model->getAttributeLabel('idno'))); ?>
                                                            <?php echo $form->error($person_model, 'idno'); ?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activeTextField($person_address, 'phone1', array('class' => 'form-control', 'numeric' => true, 'required' => true, 'placeholder' => 'Phone Number')); ?>
                                                            <i class="icon-mobile-phone"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::textField('phoneCode', '', array('class' => 'form-control', 'numeric' => true, 'required' => true, 'placeholder' => 'code sent to phone')); ?>
                                                            <i class="icon-info-sign"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php echo $form->error($person_address, 'phone1'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activeEmailField($user_model, 'email', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('email'))); ?>
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::textField('mailCode', '', array('class' => 'form-control', 'numeric' => true, 'required' => true, 'placeholder' => 'code sent to mail')); ?>
                                                            <i class="icon-info-sign"></i>
                                                        </span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php echo $form->error($user_model, 'email'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activeTextField($user_model, 'username', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('username'), 'style' => 'text-align: center')); ?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'username') ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activePasswordField($user_model, 'password', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('password'))); ?>
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'password') ?>
                                                    </label>
                                                </td> 
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo CHtml::activePasswordField($user_model, 'confirm', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('confirm'))); ?>
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                        <?php echo CHtml::error($user_model, 'confirm') ?>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style ='width:50%'>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php
                                                            $questions = SecurityQuestions::model()->findAll(array('order' => 'question ASC'));
                                                            $questions = CHtml::listData($questions, 'id', 'question');
                                                            echo $form->dropDownList($user_model, 'security_question', $questions, array('prompt' => $user_model->getAttributeLabel('security_question'), 'class' => 'form-control', 'required' => true));
                                                            ?>

                                                        </span>

                                                    </label>
                                                </td> 
                                                <td>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?php echo $form->textField($user_model, 'answer', array('class' => 'form-control', 'required' => true, 'placeholder' => $user_model->getAttributeLabel('answer'))); ?>
                                                            <i class="icon-smile"></i>
                                                        </span>

                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php echo $form->error($user_model, 'security_question'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $form->error($user_model, 'answer'); ?>
                                                </td>
                                            </tr>

                                            <?php if (isset($contribution)): ?>

                                                <tr>
                                                    <td>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <?php echo $form->dropDownList($contribution, 'payment_mode', $contribution->paymentModes(), array('style' => 'width : 100%')); ?>
                                                                <i class="icon-info-sign"></i>
                                                            </span>
                                                            <?php echo $form->error($contribution, 'payment_mode') ?>
                                                        </label>
                                                    </td> 
                                                    <td>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <?php echo $form->textField($contribution, 'transaction_no', array('class' => 'form-control',  'placeholder' => $contribution->getAttributeLabel('transaction_no'))); ?>
                                                                <i class="icon-info-sign"></i>
                                                            </span>
                                                            <?php echo $form->error($contribution, 'transaction_no') ?>
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <?php echo $form->textField($contribution, 'amount', array('class' => 'form-control', 'numeric' => true, 'required' => true, 'placeholder' => 'Registration Fee,KShs')); ?>
                                                                <i class="icon-money"></i>
                                                            </span>
                                                            <?php echo $form->error($contribution, 'amount') ?>
                                                        </label>
                                                    </td> 
                                                    <td>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <?php echo $form->textField($contribution, 'receiptno', array('class' => 'form-control', 'required' => true, 'placeholder' => $contribution->getAttributeLabel('receiptno'), 'readonly' => true)); ?>
                                                                <i class="icon-envelope-alt"></i>
                                                            </span>
                                                            <?php echo $form->error($contribution, 'receiptno') ?>
                                                        </label>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>
                                        </table>


                                        <?php if (!isset($contribution)): ?>
                                            <labe class="block clearfix">
                                                <?php if (CCaptcha::checkRequirements()): ?>
                                                    <span class="block">
                                                        <?php $this->widget('CCaptcha'); ?>
                                                        <?php echo $form->textField($user_model, 'verifyCode', array()); ?>
                                                        <p class="help-block"><?php echo Lang::t('Solve the maths problem. (Verify that you are human)') ?></p>
                                                    </span>
                                                    <?php echo $form->error($user_model, 'verifyCode'); ?>
                                                <?php endif; ?>
                                            </labe>
                                        <?php endif; ?>

                                        <div class="space"></div>
                                        <div class="clearfix">
                                            <button type="submit" class="btn btn-sm btn-success btn-block">
                                                <?php echo Lang::t('Register') ?>
                                                <i class="icon-arrow-right icon-on-right"></i>
                                            </button>
                                        </div>
                                        <div class="space-4"></div>
                                    </fieldset>

                                    <?php if (!Yii::app()->user->isGuest): ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $this->endWidget(); ?>

                    <?php if (!Yii::app()->user->isGuest): ?>
                    </div><!-- /widget-main -->
                    <!--  <div class="toolbar clearfix">
                         <div>
                             <a class="user-signup-link" href="<?php echo Yii::app()->createUrl('auth/default/login') ?>">
                    <?php echo Lang::t('Login') ?>
                             </a>
                         </div> -->
                </div>
            </div><!-- /widget-body -->
        </div><!-- /login-box -->
    </div><!-- /position-relative -->
    </div>
<?php endif; ?>