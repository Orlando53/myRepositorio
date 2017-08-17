<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-07
 * @objetivo: Mostrar sucursales
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
include_once '../../rsc/session.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}

$id_empresa = $_SESSION['IDEMPRESA'];

$columnas  = "numero_sucursales";
$tabla     = "gen_empresas";
$condicion = "id_empresa = :v1";
$valores   = array(":v1" => $id_empresa);

$rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
echo json_encode($rs_consultar);
