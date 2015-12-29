<div class="uk-grid">
        <div class="uk-width-medium-2-5">
                <article class="uk-article">
                        <h3 class="uk-article-title"><?php echo CHtml::encode($this->pageTitle) ?></h3>
                </article>
        </div>
        <div class="uk-width-medium-3-5">
                <div class="uk-button-group uk-float-right">
                        <a class="uk-button" href="<?php echo $this->createUrl('default/index') ?>">Cancel</a>
                </div>
        </div>
</div>
<hr class="uk-article-divider">
<?php $this->renderPartial('/widgets/_alert') ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>