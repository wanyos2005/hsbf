<?php
$this->breadcrumbs = array(
    Lang::t('Settings') => array('default/index'),
    $this->pageTitle,
);
?>
<div class="btn-group">
        <a class="btn btn-sm show-colorbox" href="<?php echo $this->createUrl('createCategory') ?>"><?php echo Lang::t(Constants::LABEL_CREATE . Constants::SPACE . $this->resourceLabel . Constants::SPACE . 'Category') ?></a>
</div>
<hr/>
<?php foreach ($categories as $cat): ?>
        <div class="widget-box transparent">
                <div class="widget-header widget-header-flat">
                        <h4 class="lighter"><?php echo CHtml::encode($cat['name']) ?></h4>
                        <div class="widget-toolbar">
                                <a class="delete-tax-category" href="<?php echo $this->createUrl('deleteCategory', array('id' => $cat['id'])) ?>" title="<?php echo Lang::t(Constants::LABEL_DELETE) ?>"><i class="icon-trash red"></i></a>
                                <a class="show-colorbox" href="<?php echo $this->createUrl('updateCategory', array('id' => $cat['id'])) ?>" title="<?php echo Lang::t(Constants::LABEL_UPDATE) ?>"><i class="icon-edit"></i></a>
                                <a href="#" data-action="collapse">
                                        <i class="icon-chevron-down"></i>
                                </a>
                        </div>
                </div>
                <div class="widget-body">
                        <div class="widget-body-inner">
                                <div class="widget-main">
                                        <?php $this->renderPartial('_grid', array('model' => SettingsTaxes::model()->searchModel(array('category_id' => $cat['id']), $this->settings[Constants::KEY_PAGINATION], 'name'))); ?>
                                </div>
                        </div>
                </div>
        </div>
<?php endforeach; ?>
<?php
Yii::app()->clientScript
        ->registerScriptFile($this->getPackageBaseUrl() . '/plugins/fuelux/fuelux.spinner.min.js', CClientScript::POS_END)
        ->registerScript('settings.tax', "MyController.Settings.Tax.init();");
?>
