<?php
//e10adc3949ba59abbe56e057f20f883e
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
require_once '../rsc/session.php';

$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
$user     = $_REQUEST['v0'];
$pass     = sha1($_REQUEST['v1']);
$columnas = "u.id_usuario, u.id_persona, r.id_rol, u.id_empresa, u.usuario, u.fecha_inicio, u.fecha_fin, cambio_contrasena, fecha_inicio, fecha_fin, estado, e.razon_social, e.numero_documento as emp_numero_documento, r.rol,
CONCAT_WS(' ',COALESCE(primer_nombre,' '),COALESCE(segundo_nombre,' '),COALESCE(primer_apellido,' '),COALESCE(segundo_apellido) ) AS nombre";
$tabla     = "seg_usuarios u INNER JOIN gen_personas p ON (u.id_persona = p.id_persona) INNER JOIN gen_empresas e ON (u.id_empresa = e.id_empresa) INNER JOIN seg_roles r ON (u.id_rol = r.id_rol)";
$condicion = "u.usuario = :v1 AND contrasena = :v2";
$valores   = array(":v1" => $user, ":v2" => $pass);
$rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if (count($rs) == 0) {
    echo 0; //error al consultar ussuario
    exit();
}
if ($rs[0]["cambio_contrasena"] == 0 && $rs[0]["estado"] == 1) {
    echo 1; //debe cambiar la contraseña
    exit();
}
if ($rs[0]["estado"] == 0) {
    echo 2; //usuario inactivo
    exit();
}

// vericacion de roles de usuario

switch ($rs[0]["id_rol"]) {
    //propietario
    case 1: echo 4; session::setAttribute("OPCION", 4); break;
    // ADM SISTEMA
    case 2:
        $tabla     = "gen_control_pro_inicio";
        $columnas  = "estado";
        $condicion = "id_empresa=:v1";
        $valores   = array(':v1' => $rs[0]["id_empresa"]);
        $rs3       = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
        if ($rs3) {
            if ($rs3[0]['estado'] == 1) {
                echo 4; session::setAttribute("OPCION", 4);// ya completo todos los pasos
            } else {
                echo -4; session::setAttribute("OPCION", 9);//no ha completado los pasos
            }
        } else {
            echo 04; //no se ha encontrado información de los pasos
            exit();
        }
        break;
    //empleado
    case 3:
        $tabla     = "ges_res_sociodemografico";
        $columnas  = "estado";
        $condicion = "id_empresa=:v1 AND id_persona=:v2";
        $valores   = array(':v1' => $rs[0]["id_empresa"], ':v2' => $rs[0]["id_persona"]);
        $rs2       = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
        if ($rs2) {
            echo 3; session::setAttribute("OPCION", 3);
        } else {
            echo -3; session::setAttribute("OPCION", 6);
        }
        break;

    default:
        //
        break;
}

$usu          = $rs[0]['usuario'];
$nom          = $rs[0]['nombre'];
$cam          = $rs[0]["cambio_contrasena"];
$idu          = $rs[0]["id_usuario"];
$id_rol       = $rs[0]["id_rol"];
$ide          = $rs[0]["id_empresa"];
$raiz         = dirname(__FILE__);
$raiz         = substr($raiz, 0, -5);
$rol          = $rs[0]["rol"];
$fecha_inicio = $rs[0]["fecha_inicio"];
$fecha_fin    = $rs[0]["fecha_fin"];
$idpersona    = $rs[0]["id_persona"];

session::setAttribute("IDUSUARIO", $idu);
session::setAttribute("USUARIO", $usu);
session::setAttribute("CAMBIO", $cam);
session::setAttribute("IDROL", $id_rol);
session::setAttribute("RAIZ", $raiz);
session::setAttribute("IDEMPRESA", $ide);
session::setAttribute("LOGEADO", "S");
session::setAttribute("NOMBRE", $nom);
session::setAttribute("ROL", $rol);
session::setAttribute("IDPERSONA", $idpersona);
session::setAttribute("fecha_inicio", $fecha_inicio);
session::setAttribute("fecha_fin", $fecha_fin);
$ahora = date("Y-n-j H:i:s");
session::setAttribute("ULTIMA", $ahora);


