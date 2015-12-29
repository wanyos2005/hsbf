<?=$frmHead?>	
<form id="Zone" name="Zone">
	<input type="hidden" value="Zone" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label">Zone Name</label> </td>
		<td><input type="text" id="zone_name" name="zone_name" placeholder="Zone Name" value="<?=$values_det['zone_name']?>"/></td>		
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>

					