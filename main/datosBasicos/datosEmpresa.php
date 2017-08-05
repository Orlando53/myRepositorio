<?php

/*
 * @autor:Walther Rojas
 * @fecha;2017-07-18
 * @objetivo: Registrar datos basicos empresa
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

if (!isset($_REQUEST['accion'])) {
    return;
}
$accion = $_REQUEST['accion'];
switch ($accion) {
    case 'listar':
        Listar($conn);
        break;

    case 'guardar':
        Guardar($conn);
        break;
    case 'actualizar':
        Actualizar($conn);
        break;

    default:
        # code...
        break;
}

function Listar($conn)
{
    $id_empresa = session::getAttribute('IDEMPRESA');
    $columnas   = "razon_social, id_tipo_documento, cod_dpto, co_municipio, numero_documento,url_logo,telefono,email,direccion,"
        . "numero_sucursales,id_actividad_economica,digito,nom_represente";
    $tabla      = "gen_empresas";
    $condicion  = "id_empresa=:v1";
    $valores    = array(':v1' => $id_empresa);
    $rs_empresa = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
    echo json_encode($rs_empresa);
}

function Actualizar($conn)
{
    $id_empresa = session::getAttribute('IDEMPRESA');
    $v2         = $_REQUEST['tipoDoc'];
    $v3         = $_REQUEST['numIdent'];
    $v4         = mb_strtoupper($_REQUEST['nombre']);
    $v5         = $_REQUEST['actividadEconomica'];
    $v6         = $_REQUEST['url_logo'];
    $v7         = $_REQUEST['telefono'];
    $v8         = strtolower($_REQUEST['email']);
    $v9         = $_REQUEST['direccion'];
    $v10        = $_REQUEST['dpto'];
    $v11        = $_REQUEST['mpio'];
    $v12        = $_REQUEST['sucursales'];
    $v13        = $_REQUEST['dv'];
    $v14        = strtoupper($_REQUEST['repre']);

    if (isset($_FILES['logo'])) {
        $ruta = $_SERVER['DOCUMENT_ROOT'] . '/sstplus/Temporal/' . $v3 . basename($_FILES['logo']['name']);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $ruta)) {
            $v6 = '../../Temporal/' . $v3 . basename($_FILES['logo']['name']);
        }
    }

    $tabla  = "gen_empresas";
    $campos = "id_tipo_documento=:v2, numero_documento=:v3, razon_social=:v4, id_actividad_economica=:v5, url_logo=:v6, telefono=:v7, "
        . "email=:v8, direccion=:v9, cod_dpto=:v10, co_municipio=:v11, numero_sucursales=:v12, digito=:v13, nom_represente=:v14";
    $condicion = "id_empresa=:v1";
    $valores   = array(
        ":v1" => $id_empresa, ":v2" => $v2, ":v3"   => $v3, ":v4"   => $v4, ":v5"   => $v5, ":v6"   => $v6, ":v7" => $v7, ":v8" => $v8,
        ":v9" => $v9, ":v10"        => $v10, ":v11" => $v11, ":v12" => $v12, ":v13" => $v13, ":v14" => $v14,
    );
    $rs = $conn->actualizar($tabla, $campos, $valores, $condicion);
    if ($rs > 0) {
        echo 1; // 1. registro insertado satisfactoriamente

        $columnas  = "paso1=:v2, paso2=:v3";
        $tabla     = "gen_control_pro_inicio";
        $condicion = "id_empresa=:v1";
        $valores   = array(':v1' => $id_empresa, ":v2" => 1, ":v3" => 0);
        $rs        = $conn->actualizar($tabla, $columnas, $valores, $condicion);
    } else {
        echo 0;
    }
}
