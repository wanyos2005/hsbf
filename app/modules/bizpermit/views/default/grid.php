<?php
/* @var $this DefaultController */

 $this->widget('ext.jqgrid.JqGrid', array(
       'id'=>'demo',
       'language'=>'cn',
       'options'=>array(
           'treeGrid'=>'true',
           'treeGridModel'=>'adjacency',
           'ExpandColumn'=>'name',
           'rowNum'=>'-1',
           'url'=>$model,
           'datatype'=>'',
           'treedatatype'=>'',
           'treeIcons'=>array(
               'plus'=>'icon-plus',
               'minus'=>'icon-minus',
               'leaf'=>'icon-cancel',               
           ),
           'mtype'=>'POST',
           'ExpandColClick'=>'true',
           'colNames'=>array('id', 'name'),
           'colModel'=>array(
               array(
                   'name'=>'id',
                   'index'=>'id',
                   'width'=>'100',
                   'hidden'=>false,
                   'key'=>true,
                   ),
               array(
                   'name'=>'name',
                   'index'=>'name',
                   'width'=>'300',
                   'sortable'=>false,
               ),
               ),
           'height'=>'auto',
           'caption'=>'View Groups',
       )
   ))
 
   ?>