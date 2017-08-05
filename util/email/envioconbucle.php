<?php
date_default_timezone_set('America/Bogota');
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 4;                             // Habilitar el debug

$mail->isSMTP();                                    // Usar SMTP
$mail->Host = 'softwarenuevastic.com';  					// Especificar el servidor SMTP
$mail->SMTPAuth = true;                             // Habilitar autenticacion SMTP
$mail->Username = 'software';                 	// Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
$mail->Password = 'S0wftW@re20i5';                           	// Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
$mail->SMTPSecure = 'tls';                          // Habilitar encriptacion
$mail->Port = 587;                                  // Puerto SMTP

$mail->setFrom('gerencia@nuevastic.com', 'Cristobal Castro Galindo');     			//Direccion de correo remitente
$mail->addAddress('orlando.puentes53@gmail.com','Orlando');     				// Agregar el destinatario
//$mail->addCopyTo('novum2113@gmail.com','Jose');     				//Direccion de correo para respuestas

$destinatarios = array(
   '' => '',
   '' => '',
   
);
foreach($destinatarios as $email => $name)
{
   $mail->AddCC($email, $name);
}

$mail->addCC('gerencia@nuevastic.com','Cristobal','novum2113@gmail.com','Jose');
$mail->addCC('novum2113@gmail.com','Jose');
$mail->isHTML(true);                                 // Habilitar contenido HTML

$mail->Subject = 'Mensaje de ejemplo';
$mail->Body    = 'Este es OTRO un mensaje de ejemplo <b>en HTML!</b>';

if(!$mail->send()) {
    echo 'El mensaje no pudo ser enviado';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'El mensaje ha sido enviado';
}