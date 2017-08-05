<?php

/*
 * @autor:Jose Luis Perdomo Andrade
 * @fecha;2017-13-07
 * @objetivo: Ver y responder inquietudes
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = NEW DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}

if (isset($_REQUEST["tarea"])) {
    switch ($_REQUEST["tarea"]) {
        case "consultar":
            $v1 = $_REQUEST["estado"];

            $tabla = "gen_contactos con INNER JOIN `gen_contacto_mensaje` con_men ON con.`id_contacto` = `con_men`.`id_contacto`";
            $columnas = "con.id_contacto, con_men.fecha_sistema, id_mensaje_contacto, estado, empresa, nombre_apellido, cargo, email, telefono, ciudad, mensaje";
            $condicion = "estado = :v1";
            $valores = array(
                ":v1" => $v1
            );
            //consultarCondicion($columnas, $tabla, $condicion, $valores)
            $rs = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
            if ($rs) {
                echo json_encode(array("result" => $rs, "error" => ""));
            } else {
                echo json_encode(array("result" => "", "error" => ""));
            }

            break;

        case "buscador":
            try {
                $v1 = $_REQUEST["textoBuscar"];
                $v2 = $_REQUEST["estado"];

                $tabla = "gen_contactos con INNER JOIN gen_contacto_mensaje con_men ON con.id_contacto = con_men.id_contacto";
                $columnas = "con.id_contacto, con_men.fecha_sistema, id_mensaje_contacto, estado, empresa, nombre_apellido, cargo, email, telefono, ciudad, mensaje";
                $condicion = "(empresa LIKE :v1 OR email LIKE :v1) AND estado=:v2";
                $valores = array(
                    ":v1" => "%" . $v1 . "%", ":v2" => $v2
                );
                $rs = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
                if ($rs) {
                    echo json_encode(array("result" => $rs, "error" => ""));
                } else {
                    echo json_encode(array("result" => "", "error" => ""));
                }
            } catch (Exception $ex) {
                echo json_encode($ex . message);
            }
            break;

        case "mensaje_accion":
            $v1 = $_REQUEST["id_mensaje_contacto"];

            $tabla = "gen_contacto_mensaje_accion";
            $columnas = "*";
            $condicion = "id_mensaje_contacto = :v1";
            $valores = array(
                ":v1" => $v1
            );
            $rs = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
            if ($rs) {
                echo json_encode(array("result" => $rs, "error" => ""));
            } else {
                echo json_encode(array("result" => "", "error" => ""));
            }
            break;

        case "add_mensaje_accion":
            $id = null;
            $v2 = $_REQUEST["id_mensaje_contacto"];
            $v3 = $_REQUEST["accion"];
            $v4 = $_REQUEST["mensaje"];
            $tabla = "gen_contacto_mensaje_accion";
            $columnas = "id_accion_mensaje_contacto, id_mensaje_contacto, accion, descripcion";
            $campos = ":v1, :v2, :v3, :v4";
            $valores = array(
                ":v1" => $id, ":v2" => $v2, ":v3" => $v3, ":v4" => $v4
            );
            $conn->getConexion()->beginTransaction();
            $rs = $conn->agregar($tabla, $columnas, $campos, $valores);
            if ($rs > 0) {
                $id = $v2;
                $v2 = "C";
                $tabla = "gen_contacto_mensaje";
                $campos = "estado = :v2";
                $condicion = "id_mensaje_contacto = :v1";
                $valores = array(
                    ":v1" => $id, ":v2" => $v2
                );
                $rs = $conn->actualizar($tabla, $campos, $valores, $condicion);
                if ($rs > 0) {
                    if ($_REQUEST["accion"] == 'email') {
                        if (enviarEmail() == 1) {
                            echo 1;
                            $conn->getConexion()->commit();
                        } else {
                            echo 0;
                            $conn->getConexion()->rollBack();
                        }
                    } else {
                        echo 1;
                        $conn->getConexion()->commit();
                    }
                } else {
                    echo 0;
                    $conn->getConexion()->rollBack();
                }
            } else {
                echo 0;
            }
            break;

        case "edit_mensaje_accion":
            $fecha = new DateTime();
            $id = $_REQUEST["id_accion_mensaje_contacto"];
            $v3 = strtoupper($_REQUEST["descripcion"]);
            $tabla = "gen_contacto_mensaje_accion";
            $campos = "descripcion = :v3";
            $condicion = "id_accion_mensaje_contacto = :v1";
            $valores = array(
                ":v1" => $id, ":v3" => $v3
            );
            $rs = $conn->actualizar($tabla, $campos, $valores, $condicion);
            if ($rs) {
                echo 1; // 1. registro insertado satisfactoriamente
            } else {
                echo 0;
            }
            break;

        case "rm_mensaje_accion":
            $fecha = new DateTime();
            $id = $_REQUEST["id_accion_mensaje_contacto"];
            $tabla = "gen_contacto_mensaje_accion";
            $condicion = "id_accion_mensaje_contacto = :v1";
            $valores = array(
                ":v1" => $id
            );
            $rs = $conn->eliminar($tabla, $condicion, $valores);
            if ($rs) {
                echo 1; // 1. registro insertado satisfactoriamente
            } else {
                echo 0;
            }
            break;

        default:
            echo json_encode(array("result" => array(), "error" => "Tarea incorrecta"));
            break;
    }
} else {
    echo json_encode(array("result" => array(), "error" => "No envio la tarea"));
}

function enviarEmail() {
    require '../util/email/PHPMailerAutoload.php';
    $destinatario = $_REQUEST["email"];
    $nombre = $_REQUEST["nombre"];
    $mensaje = $_REQUEST["mensaje"];
    $mail = new PHPMailer;
//    if (isset($_REQUEST["fileBase64"])) {
//        if (count_chars($_REQUEST["fileBase64"]) > 0) {
//            $Base64Img = base64_decode($_REQUEST["fileBase64"]);
//            //escribimos la información obtenida en un archivo llamado 
//            //unodepiera.png para que se cree la imagen correctamente
//            @file_put_contents($_REQUEST["fileName"], $Base64Img);
//            $mail->addAttachment($_REQUEST["fileName"], '', 'base64', '', 'attachment');
//        }
//    }
//$mail->SMTPDebug = 4;                             // Habilitar el debug

    $mail->isSMTP();                                    // Usar SMTP
    $mail->Host = 'softwarenuevastic.com';       // Especificar el servidor SMTP
    $mail->SMTPAuth = true;                             // Habilitar autenticacion SMTP
    $mail->Username = 'software';                  // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
    $mail->Password = 'S0wftW@re20i5';                            // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
    $mail->SMTPSecure = 'tls';                          // Habilitar encriptacion
    $mail->Port = 587;                                  // Puerto SMTP

    $mail->setFrom('gerencia@nuevastic.com', 'Equipo soporte');        //Direccion de correo remitente
    $mail->addAddress($destinatario, $nombre);         // Agregar el destinatario
//$mail->addCopyTo('novum2113@gmail.com','Jose');     				//Direccion de correo para respuestas
    //$mail->addCC('gerencia@nuevastic.com', 'Cristobal', 'novum2113@gmail.com', 'Jose');
    //$mail->addCC('novum2113@gmail.com', 'Jose');
    $mail->isHTML(true);                                 // Habilitar contenido HTML

    $mail->Subject = 'Respuesta Soporte';
    $mail->Body = "$mensaje";

    if (!$mail->send()) {
        return 0;
    } else {
        return 1;
    }
}

?>