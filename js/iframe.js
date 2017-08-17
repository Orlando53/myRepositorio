/**
 * @autor:		Orlando Puentes
 * @fecha: 		agosto 17 de 2017
 * @objetivo:	configuracion del iframe
 */

function cargarIframe(){
	var flag = $("#txtFlag").val();
	switch (flag) {
	case '3':url = "main/panelControl/index.php";break;
	case '6':url = "main/datosBasicos/form-preguntas.html";break;
	case '9':url = "main/index.php";break;
	default:
		break;
	}
	window.frames.iframe_a.location.href = url;
}

function resizeIframe(obj) {
    //obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    var iFrameID = document.getElementById('iframe_a');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }
  }
