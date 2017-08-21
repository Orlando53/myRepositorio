<?php 
/*
 * @autor:
 * @fecha:
 * @objetivo:
 * @Modifico:       Orlando Puentes
 * @Fecha:          julio 28 de 2018
 * @Modificacion:   cambio de extensi髇, inplementat iFrame
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    exit(0);
}
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: login/index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Control SSTPlus</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap-select.css">
	<link rel="stylesheet" href="../../css/nvst.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="icon" type="image/png" sizes="32x32" href="../../media/image/favicon-32x32.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
 	<div class="row control-panel">
 		<div class="col-xs-6">
 			<img src="../../media/image/P.png" style="position:absolute;bottom:0;right:0;">
 			<div class="col-xs-4" style="height:100%"><img src="../../media/image/planear.png" class="img-responsive indicador"></div>
 			<div class="col-xs-4" style="height:100%">
 				<ul class="panel-list jumbo">
 					<div class="jumboson">
		 				<li>
		 					<a href="#" class="panel-button"><span>Organizaci贸n</span></a>
		 				</li>
		 				<div class="dropdown-content">
		 					<ul>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Datos Empresa</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Areas de Trabajo</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Cargos</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Grupos Distribuci&oacuten</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Perfiles del Cargo</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Sucursales</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Empleados</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Mapa de Procesos</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Admin de SST</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Encuesta Sociodemogr&aacutefica</a></li>
					 		</ul>
		 				</div>
		 			</div>
		 			<div class="jumboson">
		 				<li>
		 					<a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button"><span>Diagn贸stico</span></a>
		 				</li>
		 				<div class="dropdown-content">
		 					<ul>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Datos Empresa</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Areas de Trabajo</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Cargos</a></li>
					 			<li class="item"><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button">Encuesta Sociodemogr&aacutefica</a></li>
					 		</ul>
		 				</div>	 				
		 			</div>
	 				
	 				<div class="jumboson">
		 				<li><a href class="panel-button"><span>Documentaci贸n</span></a></li>
		 				<div class="dropdown-content">
		 					<ul>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Configuraci贸n</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Admin Documento</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Admin Formato</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Diligenciar Formato</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Documentos Externos</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Documentos Caducados</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Lista Maestra Documentos</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Tipos de documentos</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Solicitar Documentos</a></li>
					 			<li class="item"><a href="documentacion/noTiene.html" target="iframe_a" class="panel-button">Papelera Reciclaje</a></li>
					 		</ul>
		 				</div>
		 			</div>
		 			
	 				<div class="jumboson">
		 				<li>
		 					<a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button"><span>Pol&iacutetica</span></a>
		 				</li>
		 				<div class="dropdown-content">
    		 				<ul>
    					 		<li class="item"><a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button">Datos Empresa</a></li>
    					 		<li class="item"><a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button">Areas de Trabajo</a></li>
    					 		<li class="item"><a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button">Cargos</a></li>
    					 		<li class="item"><a href="diagnostico/noTiene.html" target="iframe_a" class="panel-button">Encuesta Sociodemogr&aacutefica</a></li>
    					 	</ul>
    					 </div>
		 			</div>
		 			
	 			</ul>	 				
 			</div>
 			<div class="col-xs-4" style="height:100%">
 				<ul class="panel-list jumbo">
 					<div class="jumboson">
		 				<li>
		 					<a href="objetivos/noTiene.html" target="iframe_a" class="panel-button"><span>Objetivos/Indicadores</span></a>	 					
		 				</li>
		 					 				
		 			</div>
		 			<div class="jumboson">
    	 				<li><a href="#" class="panel-button"><span>Plan Trabajo</span></a></li>
    	 				<div class="dropdown-content">
    		 					<ul>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de SST</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de Salud</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de Capacitaci&oacuten</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Plan de Emergencias</a></li>
    					 		</ul>
    		 				</div>
    		 		</div>
    		 		<div class="jumboson">	 				
    	 				<li><a href="organizacion/noTiene.html" target="iframe_a" class="panel-button"><span>Matriz de Req. Legales</span></a></li>
    		 		</div>	
	 			</ul>
 			</div>
 		</div>
 		<div class="col-xs-6">
 			<img src="../../media/image/H.png" style="position:absolute;bottom:0;left:0;">
 			<div class="col-xs-6 col-xs-offset-1" style="border:0;height:100%">
 				<ul class="panel-list jumbo">
	 				<div class="jumboson">
    	 				<li><a href="#" class="panel-button"><span>Gesti&oacuten de Salud</span></a></li>
    	 				
    		 		</div>
	 				<div class="jumboson">
    	 				<li><a href="#" class="panel-button"><span>Gesti&oacuten de Riesgos</span></a></li>
    	 				<div class="dropdown-content">
    		 					<ul>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de SST</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de Salud</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Programa de Capacitaci&oacuten</a></li>
    					 			<li class="item"><a href="planes/noTiene.html" target="iframe_a" class="panel-button">Plan de Emergencias</a></li>
    					 		</ul>
    		 				</div>
    		 		</div>
	 				<li><a href="#" class="panel-button"><span>Emergencias</span></a></li>
	 				<li><a href="#" class="panel-button"><span>Contrataci贸n</span></a></li>
	 				<li><a href="#" class="panel-button"><span>Actas</span></a></li>
	 			</ul>
 			</div>
 			<div class="col-xs-1"></div>
 			<div class="col-xs-4" style="height:100%"><img src="../../media/image/hacer.png" class="img-responsive indicador"></div>
 		</div>
 		<div class="col-xs-6">
 			<img src="../../media/image/A.png" style="position:absolute;top:0;right:0;">
 			<div class="col-xs-4" style="height:100%"><img src="../../media/image/actuar.png" class="img-responsive indicador"></div>
 			<div class="col-xs-6 col-xs-offset-1" style="border:0;height:100%;">
 				<ul class="panel-list jumbo">
	 				<li><a href="#" class="panel-button"><span>Reportar ACPM</span></a></li>
	 				<li><a href="#" class="panel-button"><span>Seg. Hallazgos</span></a></li>
	 			</ul>
 			</div>
 		</div>
 		<div class="col-xs-6">
 			<img src="../../media/image/V.png" style="position:absolute;top:0;left:0;">
 			<div class="col-xs-6 col-xs-offset-1" style="border:0;height:100%;">
 				<ul class="panel-list jumbo">
	 				<li><a href="#" class="panel-button"><span>Auditorias</span></a></li>
	 				<li><a href="#" class="panel-button"><span>Revisi贸n General</span></a></li>
	 			</ul>
	 		</div>
	 			<div class="col-xs-1"></div>
 			<div class="col-xs-4" style="height:100%"><img src="../../media/image/verificar.png" class="img-responsive indicador"></div>
 		</div>
	</div>
	<script src="../../js/jquery-3.2.1.min.js"></script>
	<script src="../../js/jquery-ui.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/nvt.js"></script>
	<script>
		$(window).on('load',function(){
			var height = $(window).height();
			$('.control-panel').css('height',height+'px');
		})
	</script>
</body>
</html>
