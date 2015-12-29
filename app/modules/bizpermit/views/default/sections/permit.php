<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/fusioncharts/FusionCharts.js',CClientScript::POS_HEAD);
?>
<script type="text/javascript">
<!-- 
FusionCharts.setCurrentRenderer('javascript'); 
var myChart =new FusionCharts("<?=Yii::app()->theme->baseUrl;?>/js/fusioncharts/Column2D.swf","myChartId", "400", "300", "0", "1" );
myChart.setXMLUrl("data.xml");
myChart.render("chartContainer");
//-->
</script>
<div class="row">
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title">Registered Businesses</h4>
                        </div>
                        <div class="panel-body">
                               
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title">Paid Bills</h4>
                        </div>
                        <div class="panel-body">
                                <div id="chartContainer">FusionCharts will load here!</div>
                        </div>
                </div>
        </div>
</div>

<div class="row">
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title">Overdue Bills</h4>
                        </div>
                        <div class="panel-body">
                               
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title">Bills Analysis (Paid vs Overdue)</h4>
                        </div>
                        <div class="panel-body">
                                <div id="chartContainer">FusionCharts will load here!</div>
                        </div>
                </div>
        </div>
</div>




               

            
    

    

        