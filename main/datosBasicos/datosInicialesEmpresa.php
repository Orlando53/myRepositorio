<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-18
 * @objetivo: Registrar datos iniciales empresa
 */

@session_start();
date_default_timezone_set("America/Bogota");
ini_set("display_errors", 1);
include_once "../../rsc/DBManejador.php";
include_once "../../rsc/session.php";
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
}

$n1 = trim(mb_strtoupper($_POST['txtNombre1']));
$n2 = trim(mb_strtoupper($_POST['txtNombre2']));
$a1 = trim(mb_strtoupper($_POST['txtApellido1']));
$a2 = trim(mb_strtoupper($_POST['txtApellido2']));

$v0 = $_POST['id_plan'];
$v1 = mb_strtoupper($_POST['nombre']);
$v2 = $_POST['tipoIdentificacion'];
$v3 = $_POST['numeroIdentificacion'];
$v4 = $n1 . ' ' . $n2 . ' ' . $a1 . ' ' . $a2;
$v5 = $_POST['direccion'];
$v6 = strtolower($_POST['email']);
$v7 = $_POST['txtTelefono'];
$v8 = $_POST['numEmpleados'];
if ($v0 == 1) {
    $v9 = '1';
} else {
    $v9 = '0';
}
$v10 = '0';

$tabla    = "gen_empresas";
$columnas = "id_plan, razon_social, id_tipo_documento, numero_documento, nom_represente, direccion, email, telefono, numero_empleados, pago_confirmado, cred_enviada, nom_repre1, nom_repre2, ape_repre1, ape_repre2";
$campos   = ":v0, :v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9, :v10, :v11, :v12, :v13, :v14";
$valores  = array(":v0" => $v0, ":v1" => $v1, ":v2" => $v2, ":v3" => $v3, ":v4" => $v4, ":v5" => $v5, ":v6" => $v6, ":v7" => $v7, ":v8" => $v8, ":v9" => $v9, ":v10" => $v10, ":v11" => $n1, ":v12" => $n2, ":v13" => $a1, ":v14" => $a2);  
$rs = $conn->agregar($tabla, $columnas, $campos, $valores);
if ($rs) {
    echo 1;
    //$flag = enviarCorreo();
} else {
    echo 0;
}
// enviar evidencia del correo al admin

function enviarCorreo()
{
    require '../../util/email/PHPMailerAutoload.php';
    global $v1, $v4, $v6;
    $destinatario = $v6;
    $nombre       = $v4;
    $empresa      = $v1;
    $mensaje      = '<!DOCTYPE html>
    <html>
    <body style="background-color: #ededed;font-family:Helvetica;">
        <table style="width:100%;vertical-align: middle;">
            <tr><td colspan="3" style="height:75px;text-align: center;background-color: #ffffff;border-bottom: 3px solid #ddd;"><img src="http://i.imgur.com/0lrt35i.png" style="height:75px;;padding:5px;"></td></tr>
            <tr><td style="width:10%"></td>
                <td style="padding:15px 0">
                    <p> Cordial saludo por parte del equipo de SSTPlus</p>
                    <p> Apreciado(a) ' . $nombre . '</p>
                    <p>Está a un clic de activar SSTPlus, su Sistema de Seguridad y Salud en el Trabajo para ' . $empresa . '
                    </p>
                    <p>
                    Estamos seguros de que SSTPlus será una herramienta muy útil para implementar su SG–SST, cumplir con la normatividad evitando riesgos, sanciones y brindar bienestar a sus trabajadores.</p>
                    <p>Si no hizo esta petición puede ignorar este correo.</p>
                    <p>
                    <strong>Cordialmente, </strong><br>
                    <strong>Servicio al cliente - SSTPLus </strong>
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

    $mail->setFrom('gerencia@nuevastic.com', 'Servicio al Cliente SSTPlus'); //Direccion de correo remitente
    $mail->addAddress($destinatario, $nombre); // Agregar el destinatario
    $mail->isHTML(true); // Habilitar contenido HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Bienvenido a SSTPlus';
    $mail->Body    = "<b>$mensaje</b>";

    if (!$mail->send()) {
        return 0;
    } else {
        return 1;

    }
}

/*
 * '<div class="alert alert-danger alert-dismissable fade in" id="error">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<strong>Error!</strong> El mensaje no pudo ser enviado, por favor intente nuevamente.
</div>';

'<div class="alert alert-success alert-dismissable fade in" id="success">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<strong>Exito!</strong> El mensaje ha sido enviado al correo electrónico ' . $destinatario . '. Revise en la bandeja de entrada o en la carpeta Spam.
<p>En 24 horas nos pondremos en contacto con usted.</p>
<p>Gracias por utilizar nuestros servicios.</p>
</div>';
 */

?>