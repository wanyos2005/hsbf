<script type="text/javascript">
$(document).ready(function(){
	$("#<?=$model?>").unbind('submit').bind('submit',function(e){
		e.preventDefault();
		$("#<?=$model?> input").css('border-color','silver');
		$('.alert').children().html('');	
		$('.alert').css('display','block');
		$.post("<?=Yii::app()->baseUrl;?>/bizpermit/default/save<?=!empty($id)?"/".$id:"";?>",$("#<?=$model?>").serialize(),function(response){
			response=$.parseJSON(response);
			$(':input').css('border-color','1px solid #C0C0C0');
			$('label small').css('color','').html('');
			if(response.info=='success')
			{
				$('.alert').addClass("alert-success");
				$('.alert strong i').addClass("icon-ok");				
				$('.alert strong').append("Success!");
				$('.alert span').html("<?=ucfirst($model)?> Successfully Saved");
			}
			else if(response.info=='invalid')
			{
				$('.alert').addClass("alert-warning");
				$('.alert strong i').addClass("icon-remove");				
				$('.alert strong').append("Form Error!");
				$('.alert span').html("<?=ucfirst($model)?> Contains Errors.Please correct the fields highlighted");
						
				$.each(response.errors, function(key,value)
				{		
						$("form[name='<?=$model?>'] label[for='"+key+"']").append("<small><br/>"+value[0]+"</small>");
						$("form[name='<?=$model?>'] label[for='"+key+"'] small").css('color','red');
						$('#'+key).css('border-color','red');
				});
			}					  				
		});
	});
	
});
</script>