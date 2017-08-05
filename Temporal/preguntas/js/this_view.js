function changeForm(){  
	if 	($('#check-form').hasClass("active")){  			
		$('#blank').empty();
		for(var i=1; i<=50; i++){
			if($('#checkbox'+i).is(":checked")){
				//$('#pregunta'+i).parent().css("display","initial");
				var text = $('#checkbox'+i).parent().text(); 
				$("#blank").append('<div class="form-group col-md-2"><label for="pregunta'+i+'">'+text+'</label><input type="text" id="pregunta'+i+'" class="form-control"></div>');
								
			}
	  	}
	  	$('#check-form').removeClass("active");
  		$('#input-form').addClass("active");
  		}
  	else{
  		$('#input-form').removeClass("active");
  		$('#check-form').addClass("active");
  	}
}