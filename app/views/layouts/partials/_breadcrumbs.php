<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
    <?php /**
      $this->widget('zii.widgets.CBreadcrumbs', array(
      'homeLink' => '<li>' . CHtml::link('<i class="icon-dashboard"></i> Dashboard', array('/')) . '</li>',
      'links' => $this->breadcrumbs,
      'tagName' => 'ul',
      'separator' => '<li>',
      'htmlOptions' => array('class' => 'breadcrumb'),
      ));
     * 
     */
    ?>
    <div class="nav-search" id="nav-search">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('admin/search/index'), 'get', array('class' => 'form-search')) ?>
        <span class="input-icon">
            <?php echo CHtml::textField('q', '', array('class' => 'nav-search-input', 'id' => 'nav-search-input', 'autocomplete' => 'off', 'placeholder' => 'Search ...')) ?>
            <i class="icon-search nav-search-icon"></i>
        </span>
        <?php echo CHtml::endForm() ?>
    </div><!-- #nav-search -->
</div>
