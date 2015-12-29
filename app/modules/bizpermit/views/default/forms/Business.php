<style>
  #map_canvas {
    width: 450px;
    height: 250px;
    float: left;
  }
  #infoPanel {
    float: left;
    margin-left: 10px;
  }
  #infoPanel div {
    margin-bottom: 5px;
  }
  input
  {
  	padding: 2px !important;
  }
  td
  {
  	padding: 4px !important;
  }
 </style>
<script type="text/javascript">

function geocodePosition(pos) {
	var geocoder = new google.maps.Geocoder();

  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  //document.getElementById('info').innerHTML = [latLng.lat(),latLng.lng()].join(', ');
  document.getElementById('info').innerHTML =latLng.lat()+"<br/>"+latLng.lng();
  <?php if(empty($values_det['longitude'])):?>
  document.getElementById('latitude').value=latLng.lat();
  document.getElementById('longitude').value=latLng.lng();
  <?php endif;?>

}

function updateMarkerAddress(str) {
  document.getElementById('near').value = str;
  document.getElementById('spn_address').innerHTML= str;
}
    function initialize() {
    	var start_ltd='-1.3391860750967186';
    	var start_lng='36.825636625000016';
    	<?php if(!empty($values_det['latitude'])):?>
    	start_ltd="<?=$values_det['latitude']?>";
    	start_lng="<?=$values_det['longitude']?>";
    	<?php endif;?>
        var latLng = new google.maps.LatLng(start_ltd,start_lng);
  var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 8,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
 
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
 
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
 
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
 
  google.maps.event.addListener(marker, 'dragend', function(event) {
    updateMarkerStatus('Drag the red marker');
    //var myLatLng = event.latLng;
    //var lat = myLatLng.lat();
    //var lng = myLatLng.lng();
    geocodePosition(marker.getPosition());
  });
  var latLng = marker.getPosition(); // returns LatLng object
map.setCenter(latLng); // setCenter takes a LatLng object
google.maps.event.trigger(map, 'resize');

    }
    initialize();

</script>     


<?=$frmHead?>	

<form id="Business" name="Business" >
	<input type="hidden" value="Business" name="model"/>
	<?php if(!empty($id)):?>
	<input type="hidden" name="id" value="<?=$id?>"/>
<?php endif;?>
<table class="tbl-form">

	<tr>
		<td><label class="control-label" for="business_name">Business Name</label> </td>
		<td><input type="text" id="business_name" name="business_name" placeholder="Business Name" value="<?=$values_det['business_name']?>"/></td>	
		<td><label class="control-label" for="doc_type">ID Doc.Type</label> </td>
		<td><input type="text" id="doc_type" name="doc_type" placeholder="Identity Doc Type" value="<?=$values_det['doc_type']?>"/></td>
		<td><label class="control-label" for="doc_no">ID Doc.No</label> </td>
		<td><input type="text" id="doc_no" name="doc_no" placeholder="Doc No" value="<?=$values_det['doc_no']?>"/></td>	
		<td><label class="control-label" for="pin_no">PIN No.</label> </td>
		<td><input type="text" id="pin_no" name="pin_no" placeholder="PIN No" value="<?=$values_det['pin_no']?>"/></td>
			
	</tr>
	
	<tr>
		<td><label class="control-label" for="pin_no">VAT No.</label> </td>
		<td><input type="text" id="pin_no" name="vat_no" placeholder="VAT No" value="<?=$values_det['vat_no']?>"/></td>	
		<td><label class="control-label" for="bs_box_no">P.O BOX</label> </td>
		<td><input type="text" id="bs_box_no" name="bs_box_no" placeholder="P.O BOX No" value="<?=$values_det['bs_box_no']?>"/></td>
		<td><label class="control-label" for="bs_postal_code">Postal Code</label></td>
		<td><input type="text" id="bs_postal_code" name="bs_postal_code" placeholder="Business Postal Code" value="<?=$values_det['bs_postal_code']?>"/></td>
		<td><label class="control-label" for="bs_town">Town</label> </td>
		<td><input type="text" id="bs_town" name="bs_town" placeholder="Business Town" value="<?=$values_det['bs_town']?>"/></td>
		
								
	</tr>
	<tr>
		<td><label class="control-label" for="bs_tel_no1">Telephone 1</label> </td>
		<td><input type="text" id="bs_tel_no1" name="bs_tel_no1" placeholder="Business Tel No1" value="<?=$values_det['bs_tel_no1']?>"/></td>
		<td><label class="control-label" for="bs_tel_no2">Telephone 2</label> </td>
		<td><input type="text" id="bs_tel_no1" name="bs_tel_no2" placeholder="Business Tel No2" value="<?=$values_det['bs_tel_no2']?>"/></td>
		<td><label class="control-label" for="bs_fax_no">Fax No</label> </td>
		<td><input type="text" id="bs_tel_no1" name="bs_fax_no" placeholder="Business Tel No2" value="<?=$values_det['bs_fax_no']?>"/></td>		
		<td><label class="control-label" for="bs_email">Email Address</label> </td>
		<td><input type="text" id="bs_email" name="bs_email" placeholder="Email Address" value="<?=$values_det['bs_email']?>"/></td>	
		
						
	</tr>
	<tr>
		<td><label class="control-label" for="physical_address">Physical Address</label> </td>
		<td><input type="text" id="ct_town" name="physical_address" placeholder="Physical Address" value="<?=$values_det['physical_address']?>"/></td>
		<td><label class="control-label" for="ct_name">Contact Name</label> </td>
		<td><input type="text" id="ct_name" name="ct_name" placeholder="Contact Name" value="<?=$values_det['ct_name']?>"/></td>
		<td><label class="control-label" for="ct_designation">Designation</label> </td>
		<td><input type="text" id="ct_designation" name="ct_designation" placeholder="Designation" value="<?=$values_det['ct_designation']?>"/></td>
		<td><label class="control-label" for="ct_box_no">Postal Box</label></td>
		<td><input type="text" id="ct_box_no" name="ct_box_no" placeholder="Postal Box" value="<?=$values_det['ct_box_no']?>"/></td>		
							
	</tr>	
	<tr>
		<td><label class="control-label" for="ct_postal_code">Postal Code</label></td>
		<td><input type="text" id="ct_tel_no1" name="ct_postal_code" placeholder="Postal Code" value="<?=$values_det['ct_postal_code']?>"/></td>
		<td><label class="control-label" for="ct_tel_no1">Tel No 1.</label> </td>
		<td><input type="text" id="ct_tel_no1" name="ct_tel_no1" placeholder="Telephone 1" value="<?=$values_det['ct_tel_no1']?>"/></td>
		<td><label class="control-label" for="ct_tel_no2">Tel No 2.</label> </td>
		<td><input type="text" id="ct_tel_no2" name="ct_tel_no2" placeholder="Telephone 2" value="<?=$values_det['ct_tel_no2']?>"/></td>
		<td><label class="control-label" for="ct_fax_no">Fax No.</label> </td>
		<td><input type="text" id="ct_fax_no" name="ct_fax_no" placeholder="Fax No" value="<?=$values_det['ct_fax_no']?>"/></td>
		
	</tr>
	<tr>		
		<td><label class="control-label" for="schedule_no">Activity Code</label> </td>
		<td>
			<select type="text" id="fee_schedule" name="fee_schedule">
				<?php foreach($feeSchedule as $row):?>
					<option value="<?=$row['schedule_id']?>"><?=$row['schedule_name']?> - Ksh.<?=$row['sbp_fee']?></option>
				<?php endforeach;?>
			</select>
		</td>
		<td><label class="control-label" for="zone">Zone</label> </td>
		<td>
			<select type="text" id="zone" name="zone">
				<?php foreach($Zone as $row):?>
					<option value="<?=$row['zone_id']?>"><?=$row['zone_name']?></option>
				<?php endforeach;?>
			</select>
		</td>
		<td><label class="control-label" for="ward">Ward</label> </td>
		<td>
			<select type="text" id="ward" name="ward">
				<?php foreach($Ward as $row):?>
					<option value="<?=$row['ward_id']?>"><?=$row['ward_name']?></option>
				<?php endforeach;?>
			</select>
		</td>				
	</tr>
	<tr>
		<td>
			<label class="control-label" for="zone">Geo Location</label><br/><b>Marker status:</b>
    		<div id="markerStatus" style="font-size:10px;"><i>Drag the <br/>marker to the <br/>business location.</i></div>
    		<div style="font-size:10px;"><b>Current position : <br/> <span id="info"></span> </b></div>
    		<div style="width:80px;font-size:10px;"><b>Closest address:</b><br/> <span id="spn_address"></span></div>
		</td>
		<td colspan="6">

 
  <div id="map_canvas"></div>
  <div id="infoPanel" style="display:none">
    <div style="padding:3px;"><span><b>Latitude : </b><input id="latitude" name="latitude" value="<?=$values_det['latitude']?>"/></span><span> <b>Longitude : </b><input id="longitude" name="longitude" value="<?=$values_det['longitude']?>"/></span></div>
    <div><b>Closest matching address:</b> <input id="near" name="near" style="width:300px;" value="<?=$values_det['near']?>"/></div>
  </div>
		</td>
	</tr>
	<tr>
		<td></td><td><input type="submit" value="Submit" class="btn btn-info"/>&nbsp;<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button></td>
	</tr>

</table>
</form>
<?=$frmFoot?>
					