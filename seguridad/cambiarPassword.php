<?php

/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Restablecer Contraseña
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}

$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token     = $_POST['token'];
//$respuesta = new stdClass();
if ($password1 != "" && $password2 != "" && $idusuario != "" && $token != "") {
    $tabla     = "seg_restaurar_contrasena";
    $columnas  = "*";
    $condicion = "token = :v1";
    $valores   = array(":v1" => $token);
    $rs_res    = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

    if (count($rs_res) > 0) {

        if (sha1($rs_res[0]["id_usuario"] === $idusuario)) {

            $columnas    = "u.contrasena";
            $tabla       = "gen_personas p INNER JOIN seg_usuarios u ON (u.id_persona = p.id_persona)";
            $condicion   = "p.id_persona = :v1";
            $valores     = array(":v1" => $rs_res[0]["id_usuario"]);
            $rs_viejopas = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

            if ($password1 === $password2 && $rs_viejopas[0]["contrasena"] != sha1($password1)) {
                $tabla     = "seg_usuarios";
                $campos    = "contrasena = :v1, cambio_contrasena = :v2";
                $condicion = "id_usuario = :v3";
                $valores   = array(":v1" => sha1($password1), ":v2" => '1', ":v3" => $rs_res[0]["id_usuario"]);

                $rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);

                $tabla     = "seg_restaurar_contrasena";
                $campos    = "estado = :v1";
                $condicion = "id_usuario = :v2";
                $valores   = array(":v1" => '0', ":v2" => $rs_res[0]["id_usuario"]);

                $rs_act2 = $conn->actualizar($tabla, $campos, $valores, $condicion);

                if ($rs_act && $rs_act2) {
                    // $sql = "DELETE FROM seg_restaurar_contrasena WHERE token = '$token'";
                    // $resultado = $conexion->query( $sql );
                    echo 1;
                    //echo $respuesta->mensaje = 'La contraseña ha sido actualizada. Será re direccionado a la página de inicio.';
                    //header('Location:index.html');
                } else {
                    echo 0;
                    // echo $respuesta->mensaje = 'Ocurrió un error al actualizar la contraseña, intentalo más tarde.';
                }
            } else {
                echo 2;
                // echo $respuesta->mensaje = 'Las contraseñas no coinciden o la contraseña ingresada está actualmente en uso.';

            }

        } else {
            //echo $respuesta->mensaje = 'El token no es válido.';
            echo 3;
        }
    } else {
        echo 3;
        //echo $respuesta->mensaje = 'El token no es válido.';

    }

} else {
    header('Location:../../index.php');
}
