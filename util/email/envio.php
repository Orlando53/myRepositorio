<?php

date_default_timezone_set('America/Bogota');
require 'PHPMailerAutoload.php';
$destinatario = $_REQUEST["email"];
$nombre = $_REQUEST["nombre"];
$mensaje = $_REQUEST["mensaje"];
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
$mail->addCC('gerencia@nuevastic.com', 'Cristobal', 'novum2113@gmail.com', 'Jose');
$mail->addCC('novum2113@gmail.com', 'Jose');
$mail->isHTML(true);                                 // Habilitar contenido HTML

$mail->Subject = 'Acaba de llegar un correo de un contacto';
$mail->Body = "<b>$mensaje!</b>";

if (!$mail->send()) {
    echo 'El mensaje no pudo ser enviado';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'El mensaje ha sido enviado';
}