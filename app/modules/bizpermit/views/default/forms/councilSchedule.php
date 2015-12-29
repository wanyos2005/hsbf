<?=$frmHead?>
	
<form id="councilSchedule" name="councilSchedule">
	<input type="hidden" value="councilSchedule" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label" for="minute_date">Minute Date</label> </td>
		<td><input type="text" id="minute_date" name="schedule_name" placeholder="Minute Date" value="<?=$values_det['minute_date']?>" class="date-picker"/><i class="icon-calendar"></i></td>
		<td><label class="control-label" for="minute_no">Minute No</label> </td>
		<td><input type="text" id="minute_date" name="minute_no" placeholder="Minute No" value="<?=$values_det['minute_no']?>" class="date-picker"/><i class="icon-calendar"></i></td>		
	</tr>
	<tr>
		<td><label class="control-label" for="gazette_date">Gazette Date</label> </td>
		<td><input type="text" id="minute_date" name="gazette_date" placeholder="Gazette Date" value="<?=$values_det['gazette_date']?>" class="date-picker"/><i class="icon-calendar"></i></td>
		<td><label class="control-label" for="gazette_no">Gazette No</label> </td>
		<td><input type="text" id="minute_date" name="gazette_no" placeholder="Gazette No" value="<?=$values_det['gazette_no']?>" class="date-picker"/><i class="icon-calendar"></i></td>		
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>

					