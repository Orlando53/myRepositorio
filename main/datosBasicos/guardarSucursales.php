<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-24-07
 * @objetivo: Guardar Sucursales
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
//$logo       = $_POST['url_logo'];
$prefijo = $_POST['prefijo'];
$nombre  = $_POST['nombre'];
//$tipodoc    = $_POST['tipoDoc'];
//$numident   = $_POST['numIdent'];
$telefono  = $_POST['telefono'];
$direccion = $_POST['direccion'];
$email     = $_POST['email'];
$dpto      = $_POST['dpto'];
$mpio      = $_POST['mpio'];
$estado    = 1;

$columnas  = "numero_documento, id_tipo_documento, url_logo";
$tabla     = "gen_empresas";
$condicion = "id_empresa = :v1";
$valores   = array(":v1" => $id_empresa);

$rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if ($rs_consultar) {
    $nitEmpresa        = $rs_consultar[0]['numero_documento'];
    $url_logo          = $rs_consultar[0]['url_logo'];
    $id_tipo_documento = $rs_consultar[0]['id_tipo_documento'];

    //Guarda la sucursal
    $tablass    = "gen_sucursales";
    $columnass  = "id_empresa, prefijo, razon_social, id_tipo_documento, numero_documento, url_logo, telefono, direccion, email, cod_dpto, co_municipio, estado";
    $camposs    = ":v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9, :v10, :v11, :v12";
    $valoress   = array(":v1" => $id_empresa, ":v2" => $prefijo, ":v3" => $nombre, ":v4" => $id_tipo_documento, ":v5" => $nitEmpresa, ":v6" => $url_logo, ":v7" => $telefono, ":v8" => $direccion, ":v9" => $email, ":v10" => $dpto, ":v11" => $mpio, ":v12" => $estado);
    $rs_agregar = $conn->agregar($tablass, $columnass, $camposs, $valoress);

    if ($rs_agregar) {
        echo 1;
    } else {
        echo 0;
    }

} else {
    echo 0;
}
