<?php

/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-07-28
 * @objetivo: Crear usuario y contraseña una vez confirmado pago
 */

date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}

// Consulta si hay empresas que hayan confirmado pago pero no se les haya enviado la solicitud

$columnase  = "*";
$tablae     = "gen_empresas";
$condicione = "pago_confirmado = :v1 AND cred_enviada = :v2";
$valorese   = array(":v1" => '1', ":v2" => '0');

$rs_consultar = $conn->consultarCondicion($columnase, $tablae, $condicione, $valorese);

//Si las hay, entonces graba en gen_personas y usuarios
if ($rs_consultar) {

    foreach ($rs_consultar as $num) {

        $n1 = $num['nom_repre1'];
        $n2 = $num['nom_repre2'];
        $a1 = $num['ape_repre1'];
        $a2 = $num['ape_repre2'];

        $tablap      = "gen_personas";
        $columnasp   = "primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, estado_persona";
        $camposp     = ":v1, :v2, :v3, :v4, :v5, :v6";
        $valoresp    = array(":v1" => $n1, ":v2" => $n2, ":v3" => $a1, ":v4" => $a2, ":v5" => $num['email'], ":v6" => '1');
        $rs_agregarp = $conn->agregar($tablap, $columnasp, $camposp, $valoresp);

        if ($rs_agregarp) {

            $columnasp1  = "id_persona";
            $tablap1     = "gen_personas";
            $condicionp1 = "email = :v1 AND estado_persona = :v2";
            $valoresp1   = array(":v1" => $num['email'], ":v2" => '1');

            $rs_consultarp1 = $conn->consultarCondicion($columnasp1, $tablap1, $condicionp1, $valoresp1);

            $usuario = generarUsuario(eliminarTildes($n1), $num['numero_documento']);
            // $usuario    = $num['email'];
            $contrasena = generarContrasena();
            $fecha_fin  = generaFechaFin(date('Y-m-d'));

            //echo $usuario;

            // echo $rs_consultarp1[0]['id_persona'];
            // echo $rs_consultar[0]['id_empresa'];
            // echo $usuario;
            // echo sha1($contrasena);
            // echo date('Y-m-d');
            // echo $fecha_fin;

            $tablau      = "seg_usuarios";
            $columnasu   = "id_persona, id_rol, id_empresa, usuario, contrasena, cambio_contrasena, fecha_inicio, fecha_fin, estado";
            $camposu     = ":v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9";
            $valoresu    = array(":v1" => $rs_consultarp1[0]['id_persona'], ":v2" => '1', ":v3" => $num['id_empresa'], ":v4" => $usuario, ":v5" => sha1($contrasena), ":v6" => '0', ":v7" => date('Y-m-d'), ":v8" => $fecha_fin, ":v9" => '1');
            $rs_agregaru = $conn->agregar($tablau, $columnasu, $camposu, $valoresu);

            //echo print_r($valoresu);

            if ($rs_agregaru > 0) {
                if (enviarCorreo($num['email'], mb_strtoupper($num['nom_represente']), $usuario, $contrasena, $num['razon_social'])) {

                    $columnasae      = "cred_enviada=:v2";
                    $tablaae         = "gen_empresas";
                    $condicionae     = "id_empresa=:v1";
                    $valoresae       = array(':v1' => $num['id_empresa'], ':v2' => 1);
                    $rs_act_empresas = $conn->actualizar($tablaae, $columnasae, $valoresae, $condicionae);
                    //echo print_r($rs_act_empresas);

                    //inserta el id de la empresa en gen_control_pro_inicio
                    $tablacp      = "gen_control_pro_inicio";
                    $columnascp   = "id_empresa";
                    $camposcp     = ":v1";
                    $valorescp    = array(":v1" => $num['id_empresa']);
                    $rs_agregarcp = $conn->agregar($tablacp, $columnascp, $camposcp, $valorescp);

                    crearCarpeta($num['numero_documento']);

                } else {
                    echo "error actualizar empresa a 1 el estado de Credencial Enviada";
                }

            } else {
                echo "error agregar usuario";
            }

        }
    }

} else {
    echo 'No hay empresas con pagos pendientes';
}

function generarUsuario($string_name, $numdocx)
{
    $nomUsuario = substr($string_name, 0, 2);
    $usuario    = $nomUsuario . $numdocx;
    return $usuario;
//     $username_parts = array_filter(explode(" ", strtolower($string_name))); //pasa a minúscula y convierte a array
    //     $username_parts = array_slice($username_parts, 0, 2); //devuelve las dos primeras partes del array

//     $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //corta el primer nombre a 8 letras
    //     $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //corta el segundo nombre a 5 letras
    //     $part3 = ($rand_no) ? rand(0, $rand_no) : "";

//     $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle ordena las letras aleatoriamente
    //     return $username;
}

function crearCarpeta($numDoc)
{
    $rutainicial = $_SERVER['DOCUMENT_ROOT'] . '/Empresas/' . $numDoc . '';
    $array       = array('imagenes', 'evidencias', 'firmas', 'login');

    if (file_exists($rutainicial)) {

        foreach ($array as $carpetas) {
            mkdir($rutainicial . '/' . $carpetas . '', 0777, true);
        }

        echo 'La carpeta ' . $numDoc . ' ya existe';

    } else {
        if (!mkdir($rutainicial, 0777, true)) {
            die('Fallo al crear las carpetas...');
        } else {

            foreach ($array as $carpetas) {
                mkdir($rutainicial . '/' . $carpetas . '', 0777, true);
            }

            echo "éxito al crear carpetas...";
        }
    }

}

function generarContrasena()
{
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena = strlen($cadena);

    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass = 10;

    //Creamos la contraseña
    for ($i = 1; $i <= $longitudPass; $i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos = rand(0, $longitudCadena - 1);

        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

function generaFechaFin($fechainicio)
{

    $fechafin = strtotime('+1 year', strtotime($fechainicio));
    $fechafin = date('Y-m-j', $fechafin);

    return $fechafin;
}

function eliminarTildes($cadena)
{

    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena);

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena);

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena);

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena);

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}

function enviarCorreo($destinatario, $nombre, $usuario, $contrasena, $empresa)
{
    $enlace = $_SERVER["SERVER_NAME"] . '/sstplus/login';

    require '../util/email/PHPMailerAutoload.php';

    $mensaje = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="background-color: #ededed;font-family:Helvetica;">
        <table style="width:100%;vertical-align: middle;">
            <tr><td colspan="3" style="height:75px;text-align: center;background-color: #ffffff;border-bottom: 3px solid #ddd;"><img src="http://i.imgur.com/0lrt35i.png" style="height:75px;;padding:5px;"></td></tr>
            <tr><td style="width:10%"></td>
                <td style="padding:15px 0">
                    <p> Bienvenido a SSTPlus</p>
                    <p> Apreciado(a) ' . $nombre . '</p>
                    <p> SSTPlus para su empresa ' . $empresa . ' ha  sido activado de manera satisfactoria.
                    </p>
                    <p>
                        Para ingresar al sistema por favor haga click
                        <a href="' . $enlace . '"> AQUÍ </a>
                    </p>
                    <p>
                        Y utilice las siguientes  credenciales de inicio de sesión:
                    </p><br>
                    <p>
                        <strong>Usuario:</strong> ' . $usuario . '<br>
                        <strong>Contraseña:</strong> ' . $contrasena . '<br>
                    </p>
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
        // echo '<div class="alert alert-danger alert-dismissable fade in" id="error">
        //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //         <span aria-hidden="true">&times;</span>
        //         </button>
        //         <strong>Error!</strong> El mensaje no pudo ser enviado, por favor intente nuevamente.
        //         </div>';
        return 0;
        // enviar tabla log_email de los correos no enviados

    } else {
        // echo '<div class="alert alert-success alert-dismissable fade in" id="success">
        //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //         <span aria-hidden="true">&times;</span>
        //         </button>
        //         <strong>Exito!</strong> El mensaje ha sido enviado al correo electrónico ' . $destinatario . '. Revise en la bandeja de entrada o en la carpeta Spam.
        //         <p>En 24 horas nos pondremos en contacto con usted.</p>
        //         <p>Gracias por utilizar nuestros servicios.</p>
        //         </div>';
        return 1;
    }
}
