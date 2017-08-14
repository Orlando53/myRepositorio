<?php

/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-07-28
 * @objetivo: Crear usuario y contraseña una vez confirmado pago
 * @Modifica:	Orlando Puentes
 * @Objetivo:	
 * @fecha:		agosto 09 de 2017
 */

date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
include_once ("../rsc/constantes.php");
// Consulta si hay empresas que hayan confirmado pago pero no se les haya enviado la solicitud

$columnase  = "*";
$tablae     = "gen_empresas";
$condicione = "pago_confirmado = :v1 AND cred_enviada = :v2";
$valorese   = array(":v1" => '1', ":v2" => '0');

$rs_consultar = $conn->consultarCondicion($columnase, $tablae, $condicione, $valorese);

//Si las hay, entonces graba en gen_personas y usuarios
if ($rs_consultar) {
	$conn->begin();
    foreach ($rs_consultar as $num) {

        $n1 = $num['nom_repre1'];
        $n2 = $num['nom_repre2'];
        $a1 = $num['ape_repre1'];
        $a2 = $num['ape_repre2'];
		$tdoc = $num['id_tipo_documento'];
		$numero = $num['numero_documento'];
		$idempresa = $num['id_empresa'];
		
		//buscar persona
		$columnas = "id_persona";
		$tabla = "gen_personas";
		$condicion = "id_tipo_documento = :v1 AND numero_documento = :v2";
		$valores = array(":v1" => $tdoc, ":v2" => $numero);
		$rs_idpersona = $conn->consultarCondicion($columnas,$tabla,$condicion,$valores);
		$e = $conn->error;
		if(is_array($e)){
			echo json_encode($e[2]);
			$conn->rollback();
			exit();
		}
		if($rs_idpersona){
			$idpersona = $rs_idpersona[0]['id_persona'];
			//actulizar persona
			
			
			$e = $conn->error;
			if(is_array($e)){
				echo json_encode($e[2]);
				$conn->rollback();
				exit();
			}
		}else{
			//insert persona
			$tablap      = "gen_personas";
	        $columnasp   = "primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, estado_persona";
	        $camposp     = ":v1, :v2, :v3, :v4, :v5, :v6";
	        $valoresp    = array(":v1" => $n1, ":v2" => $n2, ":v3" => $a1, ":v4" => $a2, ":v5" => $num['email'], ":v6" => '1');
	        $idpersona = $conn->agregar($tablap, $columnasp, $camposp, $valoresp);
			$e = $conn->error;
			if(is_array($e)){
				echo json_encode($e[2]);
				$conn->rollback();
				exit();
			} 
		}
		//buscar usuario
		$columnas = "id_usuario";
		$tabla = "seg_usuarios";
        $condicion = "id_persona :=v1 AND id_empresa :=v2";
        $valores = array(":v1" => $idpersona, ":v2" => $idempresa);
        $rs_idusuario = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
        $e = $conn->error;
		if(is_array($e)){
				echo json_encode($e[2]);
				$conn->rollback();
				exit();
		} 
		if($rs_idusuario){
			//actulizar usuario
			
			$e = $conn->error;
			if(is_array($e)){
				echo json_encode($e[2]);
				$conn->rollback();
				exit();
			}
		}else{
			//usuario nuevo
			$contrasena = generarContrasena();
			$usuario = generarUsuario(eliminarTildes($n1), $num['numero_documento']);
            $fecha_fin  = generaFechaFin(date('Y-m-d'));
            $tablau      = "seg_usuarios";
            $columnasu   = "id_persona, id_rol, id_empresa, usuario, contrasena, cambio_contrasena, fecha_inicio, fecha_fin, estado";
            $camposu     = ":v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9";
            $valoresu    = array(":v1" => $idpersona, ":v2" => '1', ":v3" => $idempresa, ":v4" => $usuario, ":v5" => sha1($contrasena), ":v6" => '0', ":v7" => date('Y-m-d'), ":v8" => $fecha_fin, ":v9" => '1');
            $rs_agregaru = $conn->agregar($tablau, $columnasu, $camposu, $valoresu);
			$e = $conn->error;
			if(is_array($e)){
				echo json_encode($e[2]);
				$conn->rollback();
				exit();
			} 
            
		}
        if (!enviarCorreo($num['email'], mb_strtoupper($num['nom_represente']), $usuario, $contrasena, $num['razon_social'])) {
        	echo "No se pudo enviar el Email, error: _____";
        	$conn->rollback();
			exit();
        }
		//marcar empresa procesada	
        	
        $columnasae      = "cred_enviada=:v2";
        $tablaae         = "gen_empresas";
        $condicionae     = "id_empresa=:v1";
        $valoresae       = array(':v1' => $num['id_empresa'], ':v2' => 1);
        $rs_act_empresas = $conn->actualizar($tablaae, $columnasae, $valoresae, $condicionae);
        $tablacp      = "gen_control_pro_inicio";
        $columnascp   = "id_empresa";
        $camposcp     = ":v1";
        $valorescp    = array(":v1" => $num['id_empresa']);
        $rs_agregarcp = $conn->agregar($tablacp, $columnascp, $camposcp, $valorescp);
		$e = $conn->error;
		if(is_array($e)){
			echo json_encode($e[2]);
			$conn->rollback();
			exit();
		} 
		if(crearCarpeta($num['numero_documento'])){
			$conn->commit();
			echo "proceso realizado satisfacoriamente";
        } else {
        	$conn->rollback();
        	echo "error creando directorio de la empresa";
        }

    }
}

function generarUsuario($string_name, $numdocx)
{
    $nomUsuario = substr($string_name, 0, 2);
    $usuario    = $nomUsuario . $numdocx;
    return $usuario;
}

function crearCarpeta($numDoc)
{
    $rutainicial = $_SERVER['DOCUMENT_ROOT'] . '/Empresas/' . $numDoc . '';
    $array       = array('imagenes', 'evidencias', 'firmas', 'logo','hojas_vida');

    if (file_exists($rutainicial)) { 
		//borrar todo el arbol si existe
        foreach ($array as $carpetas) {
            mkdir($rutainicial . '/' . $carpetas . '', 0777, true);
        }

    } else {
        if (!mkdir($rutainicial, 0777, true)) {
            return false;
        } else {

            foreach ($array as $carpetas) {
                mkdir($rutainicial . '/' . $carpetas . '', 0777, true);
            }

            return true;
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

    require_once '../util/email/PHPMailerAutoload.php';

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
    $mail->Host       = HOST; // Especificar el servidor SMTP
    $mail->Username   = USEREMAIL; // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
    $mail->Password   = PASSEMAIL; // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
    $mail->SMTPAuth   = true; // Habilitar autenticacion SMTP
    $mail->SMTPSecure = 'tls'; // Habilitar encriptacion
    $mail->Port       = 587; // Puerto SMTP
    $mail->setFrom('gerencia@nuevastic.com', 'Servicio al Cliente SSTPlus'); //Direccion de correo remitente
    $mail->addAddress($destinatario, $nombre); // Agregar el destinatario
    $mail->isHTML(true); // Habilitar contenido HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Bienvenido a SSTPlus';
    $mail->Body    = "<b>$mensaje</b>";

    if (!$mail->send()) {
    	echo $mail->ErrorInfo;
        return 0;
        // enviar tabla log_email de los correos no enviados

    } else {
        return 1;
    }
}
