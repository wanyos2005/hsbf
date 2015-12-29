
<?=$frmHead?>
<form id="feeSchedule" name="feeSchedule">
	
	<input type="hidden" value="feeSchedule" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">
	<tr>
		<td><label class="control-label">Council Schedule</label> </td>
		<td>
			<select type="text" id="schedule_no" name="schedule_no">
				<?php foreach($councilSchedule as $row):?>
					<option value="<?=$row['cl_schedule_id']?>"><?=$row['schedule_no']?> - <?=$row['gazette_date']?> </option>
				<?php endforeach;?>
			</select>
		</td>
		<td><label class="control-label">Schedule Category</label> </td>
		<td>
			<select type="text" id="schedule_no" name="schedule_no">
				<?php foreach($scheduleCategory as $row):?>
					<option value="<?=$row['category_id']?>"><?=$row['category_code']?> - <?=$row['category_name']?> </option>
				<?php endforeach;?>
			</select>
		</td>		
	</tr>
	<tr>
		<td><label class="control-label" for="brims_code">Brims code </label> </td>
		<td><input type="text" id="brims_code" name="brims_code" placeholder="Brims Code" value="<?=$values_det['brims_code']?>"/></td>
		<td><label class="control-label" for="schedule_name">Schedule Name </label> </td>
		<td><input type="text" id="schedule_name" name="schedule_name" placeholder="Schedule Name" value="<?=$values_det['schedule_name']?>"/></td>		
	</tr>
	<tr>
		<td><label class="control-label" for="schedule_description">Schedule Description</label> </td>
		<td><textarea name="schedule_description" id="schedule_description" placeholder="Schedule Description"><?=$values_det['schedule_description']?></textarea></td>
		<td><label class="control-label" for="sbp_fee">SBP Fee</label> </td>
		<td><input type="text" id="sbp_fee" name="sbp_fee" placeholder="SBP Fee" value="<?=$values_det['sbp_fee']?>"/></textarea></td>	
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>
					