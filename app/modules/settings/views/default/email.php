<?php
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>
<div class="widget-box transparent">
        <div class="widget-header">
                <?php echo $this->renderPartial('settings.views.emailTemplate._tab') ?>
        </div>
        <div class="widget-body">
                <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                                <?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'POST', array('class' => 'form-horizontal', 'role' => 'form')) ?>
                                <div class="form-group">
                                        <label class="col-lg-2 control-label">Mailer:</label>
                                        <div class="col-lg-4">
                                                <?php echo CHtml::dropDownList('settings[' . Constants::KEY_EMAIL_MAILER . ']', $settings[Constants::KEY_EMAIL_MAILER], array('smtp' => 'SMTP', 'sendmail' => 'SENDMAIL'), array('class' => 'form-control', 'id' => 'settings_email_mailer')) ?>
                                                <p class="help-block">Email transport protocol</p>
                                        </div>
                                </div>
                                <br/>
                                <div id="sendmail_settings">
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Sendmail Command:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::textField('settings[' . Constants::KEY_EMAIL_SENDMAIL_COMMAND . ']', $settings[Constants::KEY_EMAIL_SENDMAIL_COMMAND], array('class' => 'form-control')) ?>
                                                </div>
                                        </div>
                                </div>
                                <br/>
                                <div id="smtp_settings">
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Mail host:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::textField('settings[' . Constants::KEY_EMAIL_HOST . ']', $settings[Constants::KEY_EMAIL_HOST], array('class' => 'form-control')) ?>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Mail host port:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::textField('settings[' . Constants::KEY_EMAIL_PORT . ']', $settings[Constants::KEY_EMAIL_PORT], array('class' => 'form-control')) ?>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Mail username:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::textField('settings[' . Constants::KEY_EMAIL_USERNAME . ']', $settings[Constants::KEY_EMAIL_USERNAME], array('class' => 'form-control')) ?>
                                                        <p class="help-block">e.g noreply@xchnge.co</p>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Mail password:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::passwordField('settings[' . Constants::KEY_EMAIL_PASSWORD . ']', $settings[Constants::KEY_EMAIL_PASSWORD], array('class' => 'form-control')) ?>
                                                        <p class="help-block">Password for the username.</p>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-lg-2 control-label">Mail security:</label>
                                                <div class="col-lg-4">
                                                        <?php echo CHtml::dropDownList('settings[' . Constants::KEY_EMAIL_SECURITY . ']', $settings[Constants::KEY_EMAIL_SECURITY], array('' => 'NULL', 'ssl' => 'SSL', 'tls' => 'TLS'), array('class' => 'form-control')) ?>
                                                </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-lg-2 control-label">Mail Theme:</label>
                                        <div class="col-lg-8">
                                                <?php echo CHtml::textArea('settings[' . Constants::KEY_EMAIL_MASTER_THEME . ']', $settings[Constants::KEY_EMAIL_MASTER_THEME], array('class' => 'form-control redactor', 'rows' => 8)) ?>
                                                <p class="help-block">Make sure that "{content}" placeholder is not removed.</p>
                                        </div>
                                </div>
                                <div class="clearfix form-actions">
                                        <div class="col-lg-offset-2 col-lg-9">
                                                <button class="btn btn-primary" <?php echo!$this->showLink($this->resource, Acl::ACTION_UPDATE) ? 'disabled="disabled"' : null ?> type="submit"><i class="icon-ok bigger-110"></i> Save</button>
                                                &nbsp; &nbsp; &nbsp;
                                                <a class="btn" href="<?php echo Yii::app()->createUrl('admin/default/index') ?>"><i class="icon-remove bigger-110"></i>Cancel</a>
                                        </div>
                                </div>
                                <?php echo CHtml::endForm() ?>
                        </div>
                </div>
        </div>
</div>
<?php
Yii::import('ext.redactor.ImperaviRedactorWidget');
$this->widget('ImperaviRedactorWidget', array(
    // the textarea selector
    'selector' => '.redactor',
    // some options, see http://imperavi.com/redactor/docs/
    'options' => array(
        'minHeight' => 200,
        'convertDivs' => false,
        'cleanup' => TRUE,
        'paragraphy' => false,
        'imageUpload' => Yii::app()->createUrl('myHelper/uploadRedactor'),
        'imageUploadErrorCallback' => new CJavaScriptExpression(
                'function(obj,json) {console.log(json.error);}'
        ),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
    ),
));

Yii::app()->clientScript->registerScript('email-settings', "
          MyController.Settings.Email.init();
");
?>