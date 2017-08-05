$(function() {
     var arr = [];
	
	$('#dialog-direccion select,#dialog-direccion input:text').bind("blur",function(){
		
		var indice = parseInt($(this).attr('tabindex'))-1;
		
		arr[indice]=$(this).val();
		$('#tDirCompleta').val('');
	   $.each(arr,function(i,n){
		if(n!=undefined){
			     var esp = (i==9)?'-':' ';
			     $('#tDirCompleta').val($.trim($('#tDirCompleta').val()+esp+n.toUpperCase()));
		    }
		});				
		//alert("Posicion "+indice+"= "+arr[indice]);
	});
});


