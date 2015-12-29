<div class="container-fluid">
    <div class="row-fluid">
      <div class="area-top clearfix">
        <div class="pull-left header">
            <h3 class="title"> <i class="icon-info-sign"></i><?php echo CHtml::encode($this->pageTitle);?></h3>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid padded">
    <div class="row-fluid">
        <div class="span12">
            <?php echo $this->renderPartial('//widgets/_alert');?>
            <div class="box">
                <div class="box-header"><span class="title">&nbsp;</span></div>
                <div class="box-content">
                   <?php $this->renderPartial('//documentation/helpCategory/_form',array('model'=>$model))?> 
                </div>
            </div>
        </div>
  </div>
</div>