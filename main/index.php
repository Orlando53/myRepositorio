<?php
/*
 *
 *
 * @Modifica:    Orlando Puentes A.
 * @fecha:        Julio 19 de 2017
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');

require_once '../rsc/session.php';
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
	<title>Bienvenido a SSTPlus</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap-select.css">
	<link rel="stylesheet" href="../css/nvst.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" type="image/png" sizes="32x32" href="../media/image/favicon-32x32.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">

</head>
<body>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-12 main-text"><h1>Bienvenido a SSTPlus</h1><p>Empieza ingresando los Datos Básicos para comenzar a usar SSTPlus</p></div>
		</div>
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6 pasos" id = "div-paso1">
			<div class="overlay"></div>
				<img src="http://via.placeholder.com/317x150">
				<h3>Paso 1</h3>
				<p>Completar Datos de la Empresa</p>
				<a href="../main/datosBasicos/registrarDatosEmpresa.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6 pasos" id = "div-paso2">
			<div class="overlay"></div>
				<img src="http://via.placeholder.com/317x150">
				<h3>Paso 2</h3>
				<p>Ingresar Areas de Trabajo</p>
				<a href="../main/datosBasicos/registrarAreasTrabajo.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
			</div>
			<div class="col-md-3 col-xs-12 pasos" id = "div-paso3">
			<div class="overlay"></div>
				<img src="http://via.placeholder.com/317x150">
				<h3>Paso 3</h3>
				<p>Ingresar Cargos de la Empresa</p>
				<a href="../main/datosBasicos/registrarCargos.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
			</div>
			<div class="col-md-3 col-xs-12 pasos" id = "div-paso4">
			<div class="overlay"></div>
				<img src="http://via.placeholder.com/317x150">
				<h3>Paso 4</h3>
				<p>Ingresar Sedes y/o Sucursales</p>
				<a href="../main/datosBasicos/registrarSucursales.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
			</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-xs-12 cont" >
					<div class="col-md-4 col-xs-12 pasos2" id = "div-paso5">
					<div class="overlay"></div>
						<img src="http://via.placeholder.com/332x150">
						<h3>Paso 5</h3>
						<p>Ingresar Empleados</p>
						<a href="../main/datosBasicos/usuarios.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
					</div>
					<div class="col-md-4 col-xs-12 pasos2" id = "div-paso6">
					<div class="overlay"></div>
						<img src="http://via.placeholder.com/332x150">
						<h3>Paso 6</h3>
						<p>Completar Encuesta Sociodemográfica</p>
						<a href="../main/datosBasicos/respuestaEncuesta.php" target="iframe_a" class="btn btn-success">Ir a Formulario</a>
					</div>
				</div>
			</div>
		</div>
		<script src="../js/jquery-3.2.1.min.js"></script>
		<script src="../js/jquery-ui.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/nvt.js"></script>
		<script src= "../js/jquery.blockUI.js"></script>
		<script src="../js/jquery.funciones.js"></script>
        <script src="js/index.js"></script>
  </body>
  </html>
