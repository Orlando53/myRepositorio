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
$logo        = $_POST['logoAct'];
$prefijo     = $_POST['PrefijoAct'];
$nombre      = $_POST['nombreAct'];
$tipodoc     = $_POST['tipoIdentificacionAct'];
$numident    = $_POST['numeroIdentificacionAct'];
$telefono    = $_POST['numTelefonoAct'];
$direccion   = $_POST['direccionAct'];
$email       = $_POST['emailAct'];
$dpto        = $_POST['selDPTOAct'][0];
$mpio        = $_POST['selMPIOAct'][0];

$columnas  = "numero_documento";
$tabla     = "gen_empresas";
$condicion = "id_empresa = :v1";
$valores   = array(":v1" => $id_empresa);

$rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if ($rs_consultar) {
    $nitEmpresa = $rs_consultar[0]['numero_documento'];
    //guarda la imagen de la sucursal
    if (isset($_FILES['logo'])) {
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/Empresas/' . $nitEmpresa . '/imagenes/' . $numident . eliminarTildes(basename($_FILES['logo']['name']));
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $ruta)) {
            $logo = $ruta;
            //Actualiza la sucursal
            $tablass       = "gen_sucursales";
            $camposs       = "prefijo = :v1, razon_social = :v2, id_tipo_documento = :v3, numero_documento = :v4, url_logo = :v5, telefono = :v6, direccion = :v7, email = :v8, cod_dpto = :v9, co_municipio = :v10";
            $condicions    = "id_empresa = :v11 AND id_sucursal = :v12";
            $valoress      = array(":v1" => $prefijo, ":v2" => $nombre, ":v3" => $tipodoc, ":v4" => $numident, ":v5" => $logo, ":v6" => $telefono, ":v7" => $direccion, ":v8" => $email, ":v9" => $dpto, ":v10" => $mpio, ":v11" => $id_empresa, ":v12" => $id_sucursal);
            $rs_actualizar = $conn->actualizar($tablas, $camposs, $valoress, $condicions);

            if ($rs_actualizar) {
                echo 1;
            } else {
                echo 0;
            }

        }
    }

} else {}

//echo $respuesta->mensaje = 'Registro actualizado satisfactoriamente.';
