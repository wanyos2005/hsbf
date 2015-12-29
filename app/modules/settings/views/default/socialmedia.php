<article class="uk-article">
        <h3 class="uk-article-title"><?php echo CHtml::encode($this->pageTitle) ?><small></small></h3>
        <hr class="uk-article-divider">
</article>
<?php $this->renderPartial('/widgets/_alert') ?>
<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'POST', array('class' => 'uk-form uk-form-horizontal uk-panel uk-panel-box')) ?>
<div class="uk-form-row">
        <label class="uk-form-label">Facebook Page:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SM_FACEBOOK_PAGE . ']', $settings[Constants::KEY_SM_FACEBOOK_PAGE], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Twitter Page:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SM_TWITTER_PAGE . ']', $settings[Constants::KEY_SM_TWITTER_PAGE], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">LinkedIn Page:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SM_LINKEDIN_PAGE . ']', $settings[Constants::KEY_SM_LINKEDIN_PAGE], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Google+ Page:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SM_GOOGLEPLUS_PAGE . ']', $settings[Constants::KEY_SM_GOOGLEPLUS_PAGE], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Youtube Page:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_SM_YOUTUBE_PAGE . ']', $settings[Constants::KEY_SM_YOUTUBE_PAGE], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<hr/>
<div class="uk-form-row">
        <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" <?php echo!$this->showLink($this->resource, Acl::ACTION_UPDATE) ? 'disabled="disabled"' : null ?> type="submit">Save</button>
                <a class="uk-button" href="<?php echo $this->createUrl('default/index') ?>">Cancel</a>
        </div>
</div>
<?php echo CHtml::endForm() ?>