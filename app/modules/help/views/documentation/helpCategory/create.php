<div class="widget">
    <div class="widget-header"><h3><?php echo CHtml::encode($this->pageTitle)?></h3></div> <!-- /widget-header -->
    <div class="widget-content mainpage">
        <?php $this->renderPartial('//widgets/_statusMessages')?>
        <div class="row-fluid">
            <div class="span12"><?php $this->renderPartial('//documentation/helpCategory/_form',array('model'=>$model))?> </div>
        </div>
    </div>
</div>