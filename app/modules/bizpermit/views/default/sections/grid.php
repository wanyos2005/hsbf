
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.dataTables.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.dataTables.bootstrap.js',CClientScript::POS_END);
?>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
 
<script type="text/javascript">
			$(function() {
				var oTable1 = $('#sample-table-2').dataTable( {
					"bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true
				});	
				 $('a.gallery').colorbox();			
			})
</script>
		
		<div class="row-fluid">
								<?php if($action_new==TRUE):?>
								<div class="table-header">
									<a class="btn btn-sm gallery" href="<?=$this->createUrl('default/form',array('entity'=>$entity));?>"><i class="icon-plus-sign"></i>Add New</a>
								</div>
								<?php endif;?>

								<table id="sample-table-2" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th class="center">
												<label>
													<input type="checkbox" />
													<span class="lbl"></span>
												</label>
											</th>
											<?php foreach($search_fields as $field):?>
												<th>
													<?php if(isset($foreign_keys)):?>
														<?php if(array_key_exists($field,$foreign_keys)):?>
															<?=ucfirst(str_replace('_'," ",$foreign_keys[$field][1]));?>
															<?php else:?>															
														<?=ucfirst(str_replace('_'," ",$field));?>
														<?php endif;?>
													<?php else:?>
													<?=ucfirst(str_replace('_'," ",$field));?>
													<?php endif;?>
												</th>
											<?php endforeach;?>	
											<th>
												Actions
											</th>										
										</tr>
									</thead>

									<tbody>

										<?php foreach($results as $row):?>
										<tr>
											<td class="center">
												<label>
													<input type="checkbox" />
													<span class="lbl"></span>
												</label>
											</td>
											<?php foreach($search_fields as $field):?>
												<td>
													<?php if(isset($foreign_keys)):?>
													<?php if(array_key_exists($field,$foreign_keys)):?>
														<?=$row->$foreign_keys[$field][0]->$foreign_keys[$field][1];?>
														<?php else:?>
													<?=$row[$field];?>
													<?php endif;?>
												<?php else:?>
												<?=$row[$field];?>		
												<?php endif;?>
												</td>
											<?php endforeach;?>	
											<td>
												<?php foreach($buttons as $button):?>
												<a class="gallery" href="<?=$this->createUrl($button[1],array('entity'=>$entity,'id'=>$row[$primary]));?>"><button class="btn btn-sm btn-danger">
															<i class="<?=$button[2]?> bigger-120"></i><?=$button[0];?>
												</button>
												</a>
												<?php endforeach;?>
												
											</td>																				
										</tr>										
									</tbody>
									<?php endforeach;?>
								</table>
		
		</div>


