<article class="uk-article">
        <h3 class="uk-article-title"><?php echo CHtml::encode($this->pageTitle) ?><small></small></h3>
        <hr class="uk-article-divider">
</article>
<?php $this->renderPartial('/widgets/_alert') ?>
<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'POST', array('class' => 'uk-form uk-form-horizontal uk-panel uk-panel-box')) ?>
<div class="uk-form-row">
        <label class="uk-form-label">Paypal email:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_EMAIL . ']', $settings[Constants::KEY_PAYPAL_EMAIL], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Exclusive Commision (&percnt;):</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::kEY_EXCLUSIVE_COMMISSION . ']', $settings[Constants::kEY_EXCLUSIVE_COMMISSION], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Non-Exclusive Commision (&percnt;):</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_NON_EXCLUSIVE_COMMISSION . ']', $settings[Constants::KEY_NON_EXCLUSIVE_COMMISSION], array('class' => 'uk-form-width-large')) ?>
        </div>
</div>
<div class="uk-form-row">
        <label class="uk-form-label">Paypal Mode:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::radioButton('settings[' . Constants::KEY_PAYPAL_MODE . ']', $settings[Constants::KEY_PAYPAL_MODE] === MyPaypal::MODE_LIVE, array('value' => MyPaypal::MODE_LIVE)) ?><label>Live Mode</label><br>
                <?php echo CHtml::radioButton('settings[' . Constants::KEY_PAYPAL_MODE . ']', $settings[Constants::KEY_PAYPAL_MODE] === MyPaypal::MODE_SANDBOX, array('value' => MyPaypal::MODE_SANDBOX)) ?><label>Sandbox Mode (Testing)</label>
        </div>
</div>
<fieldset>
        <legend>Paypal App (Live credentials)</legend>
        <div class="uk-form-row">
                <label class="uk-form-label">End Point:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_LIVE_ENDPOINT . ']', $settings[Constants::KEY_PAYPAL_LIVE_ENDPOINT], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
        <div class="uk-form-row">
                <label class="uk-form-label">App ID:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_LIVE_APP_ID . ']', $settings[Constants::KEY_PAYPAL_LIVE_APP_ID], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
        <div class="uk-form-row">
                <label class="uk-form-label">App Secret:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_LIVE_APP_SECRET . ']', $settings[Constants::KEY_PAYPAL_LIVE_APP_SECRET], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
</fieldset>
<fieldset>
        <legend>Paypal App (Testing credentials)</legend>
        <div class="uk-form-row">
                <label class="uk-form-label">End Point:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_TESTING_ENDPOINT . ']', $settings[Constants::KEY_PAYPAL_TESTING_ENDPOINT], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
        <div class="uk-form-row">
                <label class="uk-form-label">App ID:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_TESTING_APP_ID . ']', $settings[Constants::KEY_PAYPAL_TESTING_APP_ID], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
        <div class="uk-form-row">
                <label class="uk-form-label">App Secret:</label>
                <div class="uk-form-controls">
                        <?php echo CHtml::textField('settings[' . Constants::KEY_PAYPAL_TESTING_APP_SECRET . ']', $settings[Constants::KEY_PAYPAL_TESTING_APP_SECRET], array('class' => 'uk-form-width-large')) ?>
                </div>
        </div>
</fieldset>
<hr/>
<div class="uk-form-row">
        <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" <?php echo!$this->showLink($this->resource, Acl::ACTION_UPDATE) ? 'disabled="disabled"' : null ?> type="submit">Save</button>
                <a class="uk-button" href="<?php echo $this->createUrl('default/index') ?>">Cancel</a>
        </div>
</div>
<?php echo CHtml::endForm() ?>