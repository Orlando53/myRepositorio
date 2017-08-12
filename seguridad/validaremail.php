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

function generarLinkTemporal($idusuario, $username, $conn)
{

    $cadena = $idusuario . $username . rand(1, 9999999) . date('Y-m-d');
    $token  = sha1($cadena);

    $tabla     = "seg_restaurar_contrasena";
    $columnas  = "*";
    $condicion = "id_usuario = :v1 AND estado =:v2";
    $valores   = array(":v1" => $idusuario, ":v2" => '1');
    $rs_res    = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

    if (count($rs_res) > 0) {

        return false;
    } else {
        $tabla = "seg_restaurar_contrasena";
    }

    $columnas = "id_usuario, usuario, estado, token";
    $campos   = ":v1,:v2, :v3, :v4";
    $valores  = array(":v1" => $idusuario, ":v2" => $username, ":v3" => '1', ":v4" => $token);
    $rs_nuevo = $conn->agregar($tabla, $columnas, $campos, $valores);

    if ($rs_nuevo) {
        $enlace = $_SERVER["SERVER_NAME"] . '/sstplus/seguridad/restablecer.php?idusuario=' . sha1($idusuario) . '&token=' . $token;
        return $enlace;
    } else {
        return false;
    }

}

function enviarEmail($nombre, $email, $link)
{

    require '../util/email/PHPMailerAutoload.php';
    $destinatario = $email;
   // $nombre       = $nombre; 	QUE ES ESTO ING. ERICK??????

    $mensaje = '<!DOCTYPE html>
    <html>
    <body style="background-color: #ededed;font-family:Helvetica;">
        <table style="width:100%;vertical-align: middle;">
            <tr><td colspan="3" style="height:75px;text-align: center;background-color: #ffffff;border-bottom: 3px solid #ddd;"><img src="http://i.imgur.com/0lrt35i.png" style="height:75px;;padding:5px;"></td></tr>
            <tr><td style="width:10%"></td>
                <td style="padding:15px 0">
                    <p> Señor(a) ' . $nombre . ' , hemos recibido una petición para restablecer la contraseña de su cuenta.</p>
                    <p>Si hizo esta petición, haga clic en el siguiente enlace, si no hizo esta petición puede ignorar este correo.</p>
                    <p>
                    <strong>Enlace para restablecer su contraseña</strong><br>
                    <a href="' . $link . '"> Restablecer contraseña </a>
                    </p>

                </td>
                <td style="width:10%"></td>
            </tr>
            <tr><td colspan="3" style="height:15px;text-align: left;background-color: #4dc311;"><p style="padding:0 15px">Centro de Desarrollo de Nuevas Tecnologias -  <a href="http://nuevastic.com" target="_blank">NuevasTIC</a></p></td></tr>
        </table>
    </body>
    </html>';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 4;                             // Habilitar el debug

    $mail->isSMTP(); // Usar SMTP
    $mail->Host       = 'softwarenuevastic.com'; // Especificar el servidor SMTP
    $mail->SMTPAuth   = true; // Habilitar autenticacion SMTP
    $mail->Username   = 'software'; // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
    $mail->Password   = 'S0wftW@re20i5'; // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
    $mail->SMTPSecure = 'tls'; // Habilitar encriptacion
    $mail->Port       = 587; // Puerto SMTP

    $mail->setFrom('gerencia@nuevastic.com', 'Equipo soporte'); //Direccion de correo remitente
    $mail->addAddress($destinatario, $nombre); // Agregar el destinatario
    $mail->isHTML(true); // Habilitar contenido HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Restablecer contraseña';
    $mail->Body    = "<b>$mensaje</b>";

    if (!$mail->send()) {
        echo 0;
        //     echo '<div class="alert alert-danger alert-dismissable fade in" id="error">
        // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        // <span aria-hidden="true">&times;</span>
        // </button>
        // <strong>Error!</strong> El mensaje no pudo ser enviado Mailer Error: ' . $mail->ErrorInfo . '.
        // </div>';
    } else {
        echo 1;
        //     echo '<div class="alert alert-success alert-dismissable fade in" id="success">
        // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        // <span aria-hidden="true">&times;</span>
        // </button>
        // <strong>Exito!</strong> El mensaje ha sido enviado al correo electrónico ' . $destinatario . '. Revise en la bandeja de entrada o en la carpeta Spam.
        // </div>';
    }
}

$email = $_POST['email'];
//$email = 'novum2113@gmail.com';
$respuesta = new stdClass();

if ($email != "") {

    $tabla       = "gen_personas p INNER JOIN seg_usuarios u ON (u.id_persona = p.id_persona) ";
    $columnas    = "u.id_usuario, u.usuario, CONCAT(COALESCE(p.primer_nombre,''), ' ',COALESCE(p.segundo_nombre,''), ' ',COALESCE(p.primer_apellido,''), ' ',COALESCE(p.segundo_apellido,'')) AS nombre ";
    $condicion   = "p.email = :v1";
    $valores     = array(":v1" => $email);
    $rs_consulta = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

    if (count($rs_consulta) > 0) {
        $nombre       = $rs_consulta[0]["nombre"];
        $linkTemporal = generarLinkTemporal($rs_consulta[0]["id_usuario"], $rs_consulta[0]["usuario"], $conn);
        if ($linkTemporal) {
            enviarEmail($nombre, $email, $linkTemporal);
        } else {
            echo 2;
            //   echo $respuesta->mensaje = '<div class="alert alert-danger alert-dismissable fade in" id="error">
            // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            // <span aria-hidden="true">&times;</span>
            // </button>
            // <strong>Error!</strong> Ya realizó una petición de reestablecimiento de contraseña, por favor revise su bandeja de entrada o la carpeta Spam.
            // </div>';
        }

    } else {
        echo 3;
        //     echo $respuesta->mensaje = '<div class="alert alert-danger alert-dismissable fade in" id="error">
        //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                         <span aria-hidden="true">&times;</span>
        //                         </button>
        //                         <strong>Error!</strong> No existe una cuenta asociada al correo electrónico ingresado.
        //                         </div>';
        //}

    }
} else {
    echo 4;
    // echo $respuesta->mensaje = '<div class="alert alert-danger alert-dismissable fade in" id="error">
    //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                         <span aria-hidden="true">&times;</span>
    //                         </button>
    //                         <strong>Error!</strong> Debe introducir el correo electrónico de la cuenta.
    //                         </div>';
}

//echo $respuesta;
