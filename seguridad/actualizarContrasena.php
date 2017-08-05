<?php

/*
 * @Autor: Juan Diego Ninco Collazos
 *
 * @fecha:      julio 22 de 2017
 *
 *  @Objetivo: actualizar la  contraseña del usuario que ha iniciado sesión
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit();
}

$clave_actual = sha1($_REQUEST['clave_actual']);
$clave_nueva  = sha1($_REQUEST['clave_nueva']);
$usuario      = $_REQUEST['usuario'];

$columnas  = "*";
$tabla     = "seg_usuarios";
$condicion = "contrasena = :v1 AND usuario= :v2";
$valores   = array(":v1" => $clave_actual, ":v2" => $usuario);
$rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if (count($rs) == 0) {
    echo 0; //error en la consulta
    exit();
} else {

    $valores   = array(":v1" => $clave_nueva, ":v2" => 1, ":v3" => $rs[0]['id_usuario']);
    $campos    = "contrasena=:v1, cambio_contrasena=:v2";
    $condicion = "id_usuario=:v3";

    $rs = $conn->actualizar($tabla, $campos, $valores, $condicion);
    echo 1; //se actualizo correctamente

}
