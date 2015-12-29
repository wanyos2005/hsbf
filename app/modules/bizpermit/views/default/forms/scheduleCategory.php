
<?=$frmHead?>
<form id="scheduleCategory" name="scheduleCategory">
	
	<input type="hidden" value="scheduleCategory" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label" for="category_code">Category Schedule Code</label> </td>
		<td><input type="text" id="category_code" name="category_code" placeholder="Category Schedule Code" value="<?=$values_det['category_code']?>"/></td>	
		<td><label class="control-label" for="category_name">Caregory Name </label> </td>
		<td><input type="text" id="category_name" name="category_name" placeholder="Category Name" value="<?=$values_det['category_name']?>"/></td>		
	</tr>
	<tr>
		<td><label class="control-label" for="category_description">Category Description</label> </td>
		<td><textarea name="category_description" id="category_description" placeholder="Category Description"><?=$values_det['category_description']?></textarea></td>
	</tr>
	
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>
					