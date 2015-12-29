<?php $total=0; foreach($bill_items as $value){
$total+=$value['bill_item_amount'];
}
?>

<?=$frmHead?>	
<form id="Payment" name="Payment">
	<input type="hidden" value="Payment" name="model"/>
	<input type="hidden" value="<?=$bill_id?>" name="payment_bill_reference"/>	
<table class="tbl-form">
	<tr>
		<td><label class="control-label">Payment Amount</label> </td>
		<td><input type="text" id="payment_amount" name="payment_amount" placeholder="Payment Amount" value="<?=$total?>"/></td>		
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Pay Bill" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>

					