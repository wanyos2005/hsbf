<?php
$cs=Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/documentation.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/documentation.js',  CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('documentation', "
  $('.doc-list').goDoc();
");
?>
<div class="widget">
    <div class="widget-header"><h3><?php echo CHtml::encode($this->pageTitle);?></h3></div>
    <div class="widget-content">
        <?php if(Acl::hasPrivilege($this->privileges, $this->resource,  Acl::ACTION_VIEW,FALSE)){$this->renderPartial('//documentation/_tab');}?>
        <div class="row-fluid">
            <div class="span12">
                <?php echo CHtml::beginForm(Yii::app()->createUrl($this->route),'get',array('class'=>'form-search','id'=>'cat-filter'));?>
                <?php echo CHtml::dropDownList('cat_id',  isset($_GET['cat_id'])?$_GET['cat_id']:'',  CHtml::listData(array_merge(array(array('id'=>'','name'=>'All')),HelpCategory::model()->getData('id,name')),'id','name'),array('class'=>'span12','onchange'=>'MyUtils.triggerSubmit("cat-filter")'))?>
                <?php echo CHtml::endForm();?>
            </div>
        </div>
        <?php if(!empty($data)):?>
        <ol class="doc-list">
            <?php foreach ($data as $row):?>
            <li>
                <h4><?php echo CHtml::encode($row['topic']);?></h4>
                <p><?php echo CHtml::decode($row['body']);?></p>								
            </li>
            <?php endforeach;?>
        </ol>
        <?php else:?>
        <div style="display: block;" class="doc-empty">Nothing Found</div>
        <?php endif;?>
    </div>
</div> 