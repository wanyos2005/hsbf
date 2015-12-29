<?=$frmHead?>		
<form id="Ward" name="Ward">
	<input type="hidden" value="Ward" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label" for="ward_name">Ward Name</label> </td>
		<td><input type="text" id="ward_name" name="ward_name" placeholder="Ward Name" value="<?=$values_det['ward_name']?>"/></td>		
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>


					