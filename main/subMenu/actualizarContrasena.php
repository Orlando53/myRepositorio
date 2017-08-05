<?php

/*
 * @Autor: Juan Diego Ninco Collazos
 *
 * @fecha:      julio 19 de 2017
 *
 * @Objetivo: actualizar la  contraseña del usuario que ha iniciado sesión
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: index.php");
}

$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit();
}

$clave_actual = sha1($_REQUEST['clave_actual']);
$clave_nueva  = sha1($_REQUEST['clave_nueva']);

$columnas  = "*";
$tabla     = "seg_usuarios";
$condicion = "contrasena = :v1 AND id_usuario= :v2";
$valores   = array(":v1" => $clave_actual, ":v2" => $_SESSION['IDUSUARIO']);
$rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
if (count($rs) == 0) {
    echo 0; //error en la consulta
    exit();
} else {
    $valores   = array(":v1" => $clave_nueva, ":v2" => $_SESSION['IDUSUARIO']);
    $campos    = "contrasena=:v1, id_usuario=:v2";
    $condicion = "id_usuario=:v2";
    $rs        = $conn->actualizar($tabla, $campos, $valores, $condicion);

    if ($rs) {
        echo 1;
    } else {
        echo 0; //error al actualizar
        exit();
    }
}
