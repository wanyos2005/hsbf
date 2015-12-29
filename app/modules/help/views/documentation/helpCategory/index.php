<div class="widget">
    <div class="widget-header"><h3><?php echo CHtml::encode($this->pageTitle)?></h3></div> <!-- /widget-header -->
    <div class="widget-content mainpage">
        <?php echo $this->renderPartial('//documentation/_tab')?>
        <?php $this->renderPartial('//widgets/_statusMessages')?>
        <div class="row-fluid">    
            <div class="span4">
                <?php if(Acl::hasPrivilege($this->privileges, $this->resource,  Acl::ACTION_CREATE,FALSE)):?><a class="btn btn-default show-colorbox" href="<?php echo $this->createUrl('createHelpCategory')?>"><i class="icon-plus-sign"></i> Add Help Category</a><?php endif;?>
            </div>
            <div class="span8">
                <?php $form = $this->beginWidget('ext.activeSearch.ActiveSearch', array(
                         'model'=>$model,
                         'action'=>Yii::app()->createUrl($this->route,$this->actionParams),
                         'textName'=>'_search',
                         'formHtmlOptions'=>array(
                           'class'=>'form-search pull-right',
                           'id'=>'active-search-form'
                         ),
                         'textHtmlOptions'=>array(
                             'class'=>'input-large search-query',
                             'placeholder'=>'Search...'
                         ),
                     )); ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <?php $this->renderPartial('//documentation/helpCategory/_grid',array('model'=>$model))?>
    </div>
</div>