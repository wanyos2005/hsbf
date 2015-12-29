<?=$frmHead;?>	
<form id="penaltyRate" name="penaltyRate">
	<input type="hidden" value="penaltyRate" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label">Penalty Rate</label> </td>
		<td><input type="text" id="rate" name="rate" placeholder="Penalty Rate" value="<?=$values_det['rate']?>"/></td>		
	</tr>
	<tr>
		<td><label class="control-label" for="ref_date">Authority REF.Date</label> </td>
		<td><input type="text" id="ref_date" name="ref_date" placeholder="Authority REF.Date" value="<?=$values_det['ref_date']?>"/></td>
		<td><label class="control-label" for="ref_no">Authority REF.No</label> </td>
		<td><input type="text" id="ref_date" name="ref_no" placeholder="Authority REF.No" value="<?=$values_det['ref_no']?>"/></td>		
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot;?>	

					