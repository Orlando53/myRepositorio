<?php

/* !
 * @autor:        Walther Rojas
 * @fecha:        julio 25 de 2017
 * @objetivo:      Gestionar Encuesta Sociodemográfica
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
    case 'listar_respuestas':
        ListarRespuesta($conn);
        break;
    default:
        # code...
        break;
}

function Listar($conn)
{
    $columnas   = "id_pregunta, pregunta, id_tipo, detalle_def";
    $tabla      = "gen_sociodemografica";
    $rs_empresa = $conn->consultar($columnas, $tabla, true);
    echo json_encode($rs_empresa);
}

function Guardar($conn)
{
    $tabla    = "ges_res_sociodemografico";
    $columnas = "id_empresa, id_persona";
    $campos   = ":v1, :v2";

    $id_empresa = session::getAttribute('IDEMPRESA');
    $id_persona = session::getAttribute('IDPERSONA');
    $valores    = array(
        ":v1" => $id_empresa, ":v2" => $id_persona,
    );
    $rs           = $conn->agregar($tabla, $columnas, $campos, $valores);
    $id_respuesta = $conn->getConexion()->lastInsertId();

    if ($rs) {
        $tabla    = "ges_res_detalle";
        $columnas = "id_respuesta, id_pregunta, respuesta";
        $campos   = ":v1, :v2, :v3";
        foreach ($_REQUEST['respuestas'] as $pre) {
            $valores = array(
                ":v1" => $id_respuesta, ":v2" => $pre['id_pregunta'], ":v3" => $pre['id_detalle_def'],
            );
            $rs = $conn->agregar($tabla, $columnas, $campos, $valores);
        }

        if ($rs) {

            $columnas   = "paso6=:v2, paso7=:v3";
            $tabla      = "gen_control_pro_inicio";
            $condicion  = "id_empresa=:v1";
            $valores    = array(':v1' => $id_empresa, ":v2" => 1, ":v3" => 0);
            $rs_control = $conn->actualizar($tabla, $columnas, $valores, $condicion);

            $columnas   = "encuesta_sociode=:v2";
            $tabla      = "ges_empleados";
            $condicion  = "id_persona=:v1";
            $valores    = array(':v1' => $id_persona, ":v2" => 1);
            $rs_control = $conn->actualizar($tabla, $columnas, $valores, $condicion);
            echo $rs_control;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

function ListarRespuesta($conn)
{
    $id_definicion = $_REQUEST['v1'];
    $columnas      = "detalle_definicion";
    $tabla         = "gen_detalle_definicion";
    $condicion     = "id_definicion=:v1";
    $valores       = array(':v1' => $id_definicion);
    $rs_tipoIdent  = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
    echo json_encode($rs_tipoIdent);
}
