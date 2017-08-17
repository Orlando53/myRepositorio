<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-05-08
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
$id_sucursal = $_POST['idSucursal'];
//$logo        = $_POST['logoAct'];
$prefijo = $_POST['PrefijoAct'];
$nombre  = $_POST['nombreAct'];
//$tipodoc     = $_POST['tipoIdentificacionAct'];
//$numident    = $_POST['numeroIdentificacionAct'];
$telefono  = $_POST['numTelefonoAct'];
$direccion = $_POST['direccionAct'];
$email     = $_POST['emailAct'];
$dpto      = $_POST['selDPTOAct'][0];
$mpio      = $_POST['selMPIOAct'][0];

// $columnas  = "numero_documento";
// $tabla     = "gen_empresas";
// $condicion = "id_empresa = :v1";
// $valores   = array(":v1" => $id_empresa);

// $rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

//if ($rs_consultar) {
//$nitEmpresa = $rs_consultar[0]['numero_documento'];
//Actualiza la sucursal
$tabla         = "gen_sucursales";
$campos        = "prefijo = :v1, razon_social = :v2, telefono = :v3, direccion = :v4, email = :v5, cod_dpto = :v6, co_municipio = :v7";
$condicion     = "id_empresa = :v8 AND id_sucursal = :v9";
$valores       = array(":v1" => $prefijo, ":v2" => $nombre, ":v3" => $telefono, ":v4" => $direccion, ":v5" => $email, ":v6" => $dpto, ":v7" => $mpio, ":v8" => $id_empresa, ":v9" => $id_sucursal);
$rs_actualizar = $conn->actualizar($tabla, $campos, $valores, $condicion);

if ($rs_actualizar) {
    echo 1;
} else {
    echo 0;
}
//} else {
//echo 0;
//}

//echo $respuesta->mensaje = 'Registro actualizado satisfactoriamente.';
