<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-25-07
 * @objetivo: Actualizar sucursales
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

$id_empresa  = $_SESSION['IDEMPRESA'];
$id_sucursal = $_REQUEST['id_sucursal'];

$columnas  = "id_empresa, id_sucursal, prefijo, razon_social, id_tipo_documento, numero_documento, url_logo, telefono, direccion, email, cod_dpto, co_municipio";
$tabla     = "gen_sucursales";
$condicion = "id_empresa = :v1 AND id_sucursal = :v2";
$valores   = array(":v1" => $id_empresa, ":v2" => $id_sucursal);

$rs_act = $conn->consultar($columnas, $tabla, $condicion, $valores);

echo json_encode($rs_act);
