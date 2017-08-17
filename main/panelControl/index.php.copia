<?php
/* 
 * @autor:	Jhonatan Fernando Martínez
 * @fecha:	ago-03-2017
 * @objetivo:	Panel de control; vista de acceso después de introducir los datos basicos de la empresa
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');

require_once '../../rsc/session.php';
if (!session::existsAttribute("USUARIO")) {
    header("location:../../index.php");
}
$usuario = session::getAttribute("USUARIO");
$URL     = "hhtp://" . $_SERVER['HTTP_HOST'] . "/sstplus/";
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
 	<div class="row">
 		<div class="col-md-6" style="background-color: red; height:50%;"></div>
 		<div class="col-md-6" style="background-color: blue; height:50%;"></div>
 		<div class="col-md-6" style="background-color: yellow; height:50%;"></div>
 		<div class="col-md-6" style="background-color: green; height:50%;"></div>
	</div>
	<script src="../../js/jquery-3.2.1.min.js"></script>
	<script src="../../js/jquery-ui.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/nvt.js"></script>
	<script>
		$(window).load(function{
			alert('hola!');
		});
	</script>
</body>
</html>
