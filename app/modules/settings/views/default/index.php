<?php
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>
<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'POST', array('class' => 'form-horizontal', 'role' => 'form')) ?>
<div class="form-group">
        <label class="col-lg-2 control-label">Admin email:</label>
        <div class="col-lg-5">
                <?php echo CHtml::textField('settings[' . Constants::KEY_ADMIN_EMAIL . ']', $settings[Constants::KEY_ADMIN_EMAIL], array('class' => 'form-control', 'type' => 'email')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Company Name:</label>
        <div class="col-lg-5">
                <?php echo CHtml::textField('settings[' . Constants::KEY_COMPANY_NAME . ']', $settings[Constants::KEY_COMPANY_NAME], array('class' => 'form-control')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Company Email:</label>
        <div class="col-lg-5">
                <?php echo CHtml::textField('settings[' . Constants::KEY_COMPANY_EMAIL . ']', $settings[Constants::KEY_COMPANY_EMAIL], array('class' => 'form-control', 'type' => 'email')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Default Currency:  </label>
        <div class="col-lg-5">
                <?php echo CHtml::dropDownList('settings[' . Constants::KEY_CURRENCY . ']', $settings[Constants::KEY_CURRENCY], SettingsCurrency::model()->getListData('id', 'id', false), array('class' => 'form-control')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Pagination:  </label>
        <div class="col-lg-5">
                <?php echo CHtml::dropDownList('settings[' . Constants::KEY_PAGINATION . ']', $settings[Constants::KEY_PAGINATION], Common::generateIntergersList(10, 100, 10), array('class' => 'form-control')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Default Timezone:  </label>
        <div class="col-lg-5">
                <?php echo CHtml::dropDownList('settings[' . Constants::KEY_DEFAULT_TIMEZONE . ']', $settings[Constants::KEY_DEFAULT_TIMEZONE], SettingsTimezone::model()->getListData('name', 'name'), array('class' => 'form-control')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Site Name:  </label>
        <div class="col-lg-5">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SITE_NAME . ']', $settings[Constants::KEY_SITE_NAME], array('class' => 'form-control')) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Site Keywords:   </label>
        <div class="col-lg-5">
                <?php echo CHtml::textArea('settings[' . Constants::KEY_SITE_KEYWORDS . ']', $settings[Constants::KEY_SITE_KEYWORDS], array('class' => 'form-control', 'rows' => 4)) ?>
        </div>
</div>
<div class="form-group">
        <label class="col-lg-2 control-label">Site Description:    </label>
        <div class="col-lg-5">
                <?php echo CHtml::textArea('settings[' . Constants::KEY_SITE_DESCRIPTION . ']', $settings[Constants::KEY_SITE_DESCRIPTION], array('class' => 'form-control', 'rows' => 7)) ?>
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