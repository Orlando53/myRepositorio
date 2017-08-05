<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-25-07
 * @objetivo: Eliminar cargos
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

foreach ($_POST['IdsSucursales'] as $idsucursales) {

    $tabla     = "gen_sucursales";
    $campos    = "estado = :v1";
    $condicion = "id_empresa = :v2 and id_sucursal = :v3";
    $valores   = array(":v1" => '0', ":v2" => $id_empresa, ":v3" => $idsucursales);

    $rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);

}
echo 1;
//echo $respuesta->mensaje = 'Registro eliminado satisfactoriamente.';
