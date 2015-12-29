<?php
$this->breadcrumbs = array(
    Lang::t(Common::pluralize($this->resourceLabel)) => array('index'),
    $this->pageTitle,
);
?>
<div class="tabbable">
        <?php $this->renderPartial('_tabs', array('model' => $model)) ?>
        <div class="tab-content no-border padding-24">
                <div class="row">
                        <div class="col-md-6">
                                <?php $this->renderPartial('_view_pending_orders', array('model' => $model)); ?>
                                <?php $this->renderPartial('_view_details', array('model' => $model)); ?>
                                <?php $this->renderPartial('_view_contact_person', array('model' => $model)); ?>
                        </div>
                        <div class="col-md-6">
                                <div class="well" style="height: 500px">
                                        <h1>GOOGLE MAP HERE</h1>
                                </div>
                        </div>
                </div>
        </div>
</div>


