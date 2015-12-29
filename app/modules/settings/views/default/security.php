<article class="uk-article">
        <h3 class="uk-article-title"><?php echo CHtml::encode($this->pageTitle) ?><small></small></h3>
        <hr class="uk-article-divider">
</article>
<?php $this->renderPartial('/widgets/_alert') ?>
<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'POST', array('class' => 'uk-form uk-form-horizontal uk-panel uk-panel-box')) ?>
<div class="uk-form-row">
        <label class="uk-form-label">Maximum item downloads:</label>
        <div class="uk-form-controls">
                <?php echo CHtml::textField('settings[' . Constants::KEY_MAX_DOWNLOADS . ']', $settings[Constants::KEY_MAX_DOWNLOADS], array('class' => 'uk-form-width-small')) ?>
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