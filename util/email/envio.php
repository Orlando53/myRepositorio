<?php
@session_start();
date_default_timezone_set('America/Bogota');
error_reporting(E_ERROR | E_PARSE);
$URLactual = $_SESSION["DOMINIO"];

class envio
{
    public function enviarCorreo($destinatario, $nombre, $mensaje, $asunto)
    {
        date_default_timezone_set('America/Bogota');
        require_once 'PHPMailerAutoload.php';
        include_once $URLactual . 'rsc/constantes.php';
        // $destinatario = $_REQUEST["email"];
        // $nombre       = $_REQUEST["nombre"];
        // $mensaje      = $_REQUEST["mensaje"];
        $mail = new PHPMailer;
        if (isset($_REQUEST["fileBase64"])) {
            if (count_chars($_REQUEST["fileBase64"]) > 0) {
                $Base64Img = base64_decode($_REQUEST["fileBase64"]);
                //escribimos la información obtenida en un archivo llamado
                //unodepiera.png para que se cree la imagen correctamente
                @file_put_contents($_REQUEST["fileName"], $Base64Img);
                $mail->addAttachment($_REQUEST["fileName"], '', 'base64', '', 'attachment');
            }
        }
//$mail->SMTPDebug = 4;                             // Habilitar el debug

        $mail->isSMTP(); // Usar SMTP
        $mail->Host       = HOST; // Especificar el servidor SMTP
        $mail->SMTPAuth   = true; // Habilitar autenticacion SMTP
        $mail->Username   = USEREMAIL; // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
        $mail->Password   = PASSEMAIL; // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
        $mail->SMTPSecure = 'tls'; // Habilitar encriptacion
        $mail->Port       = 587; // Puerto SMTP

        $mail->setFrom('gerencia@nuevastic.com', 'Equipo soporte'); //Direccion de correo remitente
        $mail->addAddress($destinatario, $nombre); // Agregar el destinatario
        //$mail->addCopyTo('novum2113@gmail.com','Jose');                     //Direccion de correo para respuestas
        // $mail->addCC('gerencia@nuevastic.com', 'Cristobal', 'novum2113@gmail.com', 'Jose');
        // $mail->addCC('novum2113@gmail.com', 'Jose');
        $mail->isHTML(true); // Habilitar contenido HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $asunto;
        $mail->Body    = "<b>$mensaje</b>";

        if (!$mail->send()) {
            return $mail->ErrorInfo;
        } else {
            return 1;
        }

    }

}
