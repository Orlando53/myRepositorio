<?php

/*
 * @autor:Jose Luis Perdomo Andrade
 * @fecha;2017-12-07
 * @objetivo: Registro contacto
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';

$rs = taerIdContacto();

if ($rs) {
    if (registrarMensajeContacto($rs[0]["id_contacto"])) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    if (registrarContacto()) {
        $rs = taerIdContacto();
        if (registrarMensajeContacto($rs[0]["id_contacto"])) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

function taerIdContacto() {
    $conn = NEW DBManejador();
    if ($conn == null) {
        echo -1;
        exit(0);
    }
    $v1 = strtoupper($_REQUEST['empresa']);
    $v2 = $_REQUEST['email'];
    $tabla = "gen_contactos";
    $columnas = "id_contacto";
    $condicion = "empresa = :v1 AND email = :v2";
    $valores = array(
        ":v1" => $v1,
        ":v2" => $v2
    );

    return $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
}

function registrarContacto() {
    $conn = NEW DBManejador();
    if ($conn == null) {
        echo -1;
        exit(0);
    }
    $id = null;
    $v2 = strtoupper($_REQUEST['empresa']);
    $v3 = strtoupper($_REQUEST['nombre']);
    $v4 = strtoupper($_REQUEST['cargo']);
    $v5 = $_REQUEST['email'];
    $v6 = $_REQUEST['telefono'];
    $v7 = strtoupper($_REQUEST['ciudad']);

    $tabla = "gen_contactos";
    $columnas = "id_contacto, empresa, nombre_apellido, cargo, email, telefono, ciudad";
    $campos = ":v1, :v2, :v3, :v4, :v5, :v6, :v7";
    $valores = array(
        ":v1" => $id, ":v2" => $v2, ":v3" => $v3, ":v4" => $v4, ":v5" => $v5, ":v6" => $v6, ":v7" => $v7
    );


    return $conn->agregar($tabla, $columnas, $campos, $valores);
}

function registrarMensajeContacto($idContacto) {
    $conn = NEW DBManejador();
    if ($conn == null) {
        echo -1;
        exit(0);
    }
    $id = null;
    $v2 = $idContacto;
    $v3 = strtoupper($_REQUEST['mensaje']);
    $v4 = "R";

    $tabla = "gen_contacto_mensaje";
    $columnas = "id_mensaje_contacto, id_contacto, mensaje, estado";
    $campos = ":v1, :v2, :v3, :v4";
    $valores = array(
        ":v1" => $id, ":v2" => $v2, ":v3" => $v3, ":v4" => $v4
    );


    return $conn->agregar($tabla, $columnas, $campos, $valores);
}

?>