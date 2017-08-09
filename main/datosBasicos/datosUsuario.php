<?php

/*
 * @autor:         Juan Diego Ninco Collazos
 * @fecha:         24-07-2017
 * @objetivo:      establecer las acciones del formulario de usuarios
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: index.php");
}
include_once '../../rsc/DBManejador.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit();
}

switch ($_REQUEST['accion']) {
    case 'insert':
        guardarUsuario();
        break;
    case 'activarUsuario':
        activarUsuario();
        break;
    case 'consultarRegistro':
        consultarRegistro();
        break;
    case 'eliminarRegistro':
        eliminarRegistro();
        break;
    case 'update':
        actualizarRegistro();
        break;
    case 'reenviarCorreo':
        reenviarCorreo();
        break;
    default:
        # code...
        break;
}

function parametros()
{
    $values = array(
        'primerNombre'      => strtoupper($_REQUEST['primerNombre']),
        'segundoNombre'     => strtoupper($_REQUEST['segundoNombre']),
        'primerApellido'    => strtoupper($_REQUEST['primerApellido']),
        'segundoApellido'   => strtoupper($_REQUEST['segundoApellido']),
        'tipoDocumento'     => $_REQUEST['tipoDocumento'],
        'numeroDocumento'   => $_REQUEST['numeroDocumento'],
        'correoElectronico' => $_REQUEST['correoElectronico'],
        'cargo'             => $_REQUEST['cargo'],
        'area'              => $_REQUEST['area'],
        'jefeInmediato'     => $_REQUEST['jefeInmediato'],
        'sucursal'          => $_REQUEST['sucursal'],
        'img_foto'          => $_REQUEST['img_foto'],
        'img_firma'         => $_REQUEST['img_firma'],

    );
    return $values;
}

function generaPass()
{
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890*$.@=";
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

function consultarDocumentoEmpresa($id_empresa)
{

    $conn      = new DBManejador();
    $columnas  = "numero_documento";
    $tabla     = "gen_empresas";
    $condicion = "id_empresa=:v1";
    $valores   = array(":v1" => $id_empresa);
    $rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
    if ($rs) {
        foreach ($rs as $row) {
            return $row['numero_documento'];
        }
    } else {
        echo 0;
        exit();
    }
}

function guardarUsuario()
{
    $conn       = new DBManejador();
    $id_empresa = session::getAttribute('IDEMPRESA');
    $values     = parametros();
    $conexion   = $conn->getConexion();

    try {
        //verificar existencia de correo electronico
        $columnas  = "*";
        $tabla     = "seg_usuarios";
        $condicion = "usuario=:v1";
        $valores   = array(":v1" => $values['correoElectronico']);
        $rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
        if ($rs) {
            //el correo electronico ya existe
            throw new Exception('El correo ya existe');
        }
    } catch (Exception $ex) {
        echo -5;
        exit();
    }

    try {
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comenzar una transacción, desactivando el modo 'autocommit'
        $conexion->beginTransaction();

        // se registran los datos basicos de la persona
        $tabla    = "gen_personas";
        $columnas = "id_tipo_documento, numero_documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email";
        $campos   = ":v1, :v2, :v3, :v4, :v5, :v6, :v7";
        $valores  = array(
            ":v1" => $values['tipoDocumento'], ":v2"   => $values['numeroDocumento'], ":v3" => $values['primerNombre'], ":v4" => $values['segundoNombre'], ":v5" => $values['primerApellido'],
            ":v6" => $values['segundoApellido'], ":v7" => $values['correoElectronico']);
        $query = $conexion->prepare("INSERT INTO " . $tabla . " (" . $columnas . ") VALUES (" . $campos . ")");
        $query->execute($valores);
        $idPersona = $conexion->lastInsertId();

        // se registran datos  laborales de la persona
        $destino             = "../../../Empresas/" . consultarDocumentoEmpresa($id_empresa) . "/imagenes";
        $foto_predeterminada = "../../media/image/placeholderPhoto.png";
        if (isset($_FILES['foto']['name'])) {
            $nombre_foto = $_FILES['foto']['name'];
            $tipo_foto   = $_FILES['foto']['type'];
            $tamano_foto = $_FILES['foto']['size'];
            $tmp_foto    = $_FILES['foto']['tmp_name'];
            $ruta_foto   = $destino . '/' . rand(1, 1000) . $nombre_foto;
            move_uploaded_file($tmp_foto, $ruta_foto);
        } else {
            $ruta_foto = $foto_predeterminada;
        }
        $destino = "../../../Empresas/" . consultarDocumentoEmpresa($id_empresa) . "/firmas";
        if (isset($_FILES['firma']['name'])) {
            $nombre_firma = $_FILES['firma']['name'];
            $tipo_firma   = $_FILES['firma']['type'];
            $tamano_firma = $_FILES['firma']['size'];
            $tmp_firma    = $_FILES['firma']['tmp_name'];
            $ruta_firma   = $destino . '/' . rand(1, 1000) . $nombre_firma;
            move_uploaded_file($tmp_firma, $ruta_firma);
        } else {
            $ruta_firma = $foto_predeterminada;
        }

        $jefe = 0;
        if ($values['jefeInmediato'] != "") {
            $jefe = $values['jefeInmediato'];
        }

        $sucursal = 0;
        if ($values['sucursal'] != "") {
            $sucursal = $values['sucursal'];
        }

        $tabla    = "ges_empleados";
        $columnas = "id_empresa, id_persona, id_persona_jefe, url_foto, url_firma, id_cargo, id_area_trabajo, estado_empleado, id_sucursal";
        $campos   = ":v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9";

        $valores = array(":v1" => $id_empresa, ":v2" => $idPersona, ":v3" => $jefe, ":v4" => $ruta_foto
            , ":v5" => $ruta_firma, ":v6" => $values['cargo'], ":v7" => $values['area'], ":v8" => 1, ":v9" => $sucursal);
        $query = $conexion->prepare("INSERT INTO " . $tabla . " (" . $columnas . ") VALUES (" . $campos . ")");
        $query->execute($valores);
        $idEmpleado = $conexion->lastInsertId();

        // se registran los datos del usuario para el ingreso al sistema.
        $tabla    = 'seg_usuarios';
        $columnas = 'id_persona, id_rol, id_empresa, usuario, contrasena, cambio_contrasena, fecha_inicio, estado';
        $campos   = ":v1, :v2, :v3, :v4, :v5, :v6, :v7, :v8";
        $usuario  = "usuariosstplus";
        $password = generaPass();
        $sha1Pass = sha1($password);
        $valores  = array(':v1' => $idPersona, ":v2" => 3, ":v3" => $id_empresa, ":v4" => $values['correoElectronico'], ":v5" => $sha1Pass, ":v6" => 0, ":v7" => date('Y-m-d'), ":v8" => 0);
        $query    = $conexion->prepare("INSERT INTO " . $tabla . " (" . $columnas . ") VALUES (" . $campos . ")");
        $query->execute($valores);
        $idUsuario = $conexion->lastInsertId();

        // Se envia el correo electronico con el usuario y password
        $rutaActivaUsuario = $_SERVER['SERVER_NAME'] . "/sstplus/main/datosBasicos/datosUsuario.php?accion=activarUsuario&token=" . $sha1Pass . "&id=" . $idUsuario;
        $nombre            = $values['primerNombre'] . ' ' . $values['segundoNombre'] . ' ' . $values['primerApellido'] . ' ' . $values['segundoApellido'];
        $asunto            = "Usuario creado";
        $mensaje           = '<!DOCTYPE html>
        <html>
        <head>
        <meta content="text/html; charset=utf-8">
        </head>
        <body style="background-color: #ededed;font-family:Helvetica;">
            <table style="width:100%;vertical-align: middle;">
                <tr><td colspan="3" style="height:75px;text-align: center;background-color: #ffffff;border-bottom: 3px solid #ddd;"><img src="http://i.imgur.com/0lrt35i.png" style="height:75px;;padding:5px;"></td></tr>
                <tr><td style="width:10%"></td>
                    <td style="padding:15px 0">
                        <p> Señor(a) ' . $nombre . ' , usted ha sido registrado en SSTplus y se le ha creado una cuenta para que ingrese.</p>
                        <p><strong>Usuario= </strong>' . $values['correoElectronico'] . '</p>
                        <p><strong>Contraseña= </strong>' . $password . '</p>
                        <p>Para comenzar a usar su cuenta de usuario, haga clic en el siguiente
                        enlace:<br>
                        </p>
                        <p>
                        <a href="' . $rutaActivaUsuario . '"> Activar usuario SSTplus</a>
                        </p>

                    </td>
                    <td style="width:10%"></td>
                </tr>
                <tr><td colspan="3" style="height:15px;text-align: left;background-color: #4dc311;"><p style="padding:0 15px">Centro de Desarrollo de Nuevas Tecnologias -  <a href="http://nuevastic.com" target="_blank">NuevasTIC</a></p></td></tr>
            </table>
        </body>
        </html>';

        // Consignar los cambios
        $conexion->commit();
        $result = enviarCorreoUsuario($values['correoElectronico'], $nombre, $mensaje, $asunto);
        if (!empty($result)) {
            echo $result;
        } else {
            echo 1;
        }
    } catch (Exception $e) {
        echo 0; //no se guardaron los datos
        // Reconocer el error y revertir los cambios
        $conexion->rollBack();
    }

}
function enviarCorreoUsuario($email, $nombre, $mensaje, $asunto)
{
    require '../../util/email/PHPMailerAutoload.php';

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
    $mail->addAddress($email, $nombre); // Agregar el destinatario
    $mail->isHTML(true); // Habilitar contenido HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $asunto;
    $mail->Body    = "<b>" . $mensaje . "</b>";

    if (!$mail->send()) {
        return -2;
    }
}

function reenviarCorreo()
{
    $conn       = new DBManejador();
    $id_persona = $_REQUEST['id_persona'];
    $id_empresa = session::getAttribute('IDEMPRESA');
    $password   = generaPass();
    $sha1Pass   = sha1($password);
    $columnas   = "p.email, u.id_usuario, u.usuario, u.contrasena, p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido";
    $tabla      = "seg_usuarios u INNER JOIN gen_personas p ON u.id_persona=p.id_persona";
    $condicion  = "u.id_persona = :v1 AND u.id_empresa=:v2";
    $valores    = array(":v1" => $id_persona, ":v2" => $id_empresa);
    $rs         = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

    if (empty($rs)) {
        echo -5;
        exit();
    }

    // Se envia el correo electronico con el usuario y password
    $rutaActivaUsuario = $_SERVER['SERVER_NAME'] . "/sstplus/main/datosBasicos/datosUsuario.php?accion=activarUsuario&token=" . $sha1Pass . "&id=" . $rs[0]['id_usuario'];
    $nombre            = $rs[0]['primer_nombre'] . ' ' . $rs[0]['segundo_nombre'] . ' ' . $rs[0]['primer_apellido'] . ' ' . $rs[0]['segundo_apellido'];
    $asunto            = "No ha activado su cuenta de usuario";
    $mensaje           = '<!DOCTYPE html>
        <html>
        <head>
        <meta content="text/html; charset=utf-8">
        </head>
        <body style="background-color: #ededed;font-family:Helvetica;">
            <table style="width:100%;vertical-align: middle;">
                <tr><td colspan="3" style="height:75px;text-align: center;background-color: #ffffff;border-bottom: 3px solid #ddd;"><img src="http://i.imgur.com/0lrt35i.png" style="height:75px;;padding:5px;"></td></tr>
                <tr><td style="width:10%"></td>
                    <td style="padding:15px 0">
                        <p> Señor(a) ' . $nombre . ' , usted ha sido registrado en SSTplus y se le ha creado una cuenta para que ingrese.</p>
                        <p><strong>Usuario= </strong>' . $rs[0]['email'] . '</p>
                        <p><strong>Contraseña= </strong>' . $password . '</p>
                        <p>Para comenzar a usar su cuenta de usuario, haga clic en el siguiente
                        enlace:<br>
                        </p>
                        <p>
                        <a href="' . $rutaActivaUsuario . '"> Activar usuario SSTplus</a>
                        </p>

                    </td>
                    <td style="width:10%"></td>
                </tr>
                <tr><td colspan="3" style="height:15px;text-align: left;background-color: #4dc311;"><p style="padding:0 15px">Centro de Desarrollo de Nuevas Tecnologias -  <a href="http://nuevastic.com" target="_blank">NuevasTIC</a></p></td></tr>
            </table>
        </body>
        </html>';
    $tabla     = 'seg_usuarios';
    $campos    = 'contrasena=:v1';
    $valores   = array(':v1' => $sha1Pass, ':v2' => $id_persona, ':v3' => $id_empresa);
    $condicion = "id_persona = :v2 AND id_empresa=:v3";
    $rs        = $conn->actualizar($tabla, $campos, $valores, $condicion);
    if ($rs) {
        $result = enviarCorreoUsuario($rs[0]['email'], $nombre, $mensaje, $asunto);
        if (!empty($result)) {
            echo $result;
            exit();
        } else {
            echo 0;
        }
        echo 1;
        exit();
    } else {
        echo 0;
    }
}

function activarUsuario()
{
    $conn     = new DBManejador();
    $password = $_REQUEST['token'];
    $id       = $_REQUEST['id'];

    $tabla     = 'seg_usuarios';
    $campos    = 'estado=:v1';
    $valores   = array(':v1' => 1, ':v2' => $password, ':v3' => $id);
    $condicion = 'contrasena=:v2 AND id_usuario=:v3';
    $rs        = $conn->actualizar($tabla, $campos, $valores, $condicion);
    if ($rs) {
        header('Location:../../login');
    } else {
        echo "<h3>No se ha podido activar el usuario, intente ingresar al link nuevamente !</h3>"; //error al activar la  cuenta
        exit();
    }
}

function consultarRegistro()
{
    $conn = new DBManejador();

    $id_persona = $_REQUEST['id_persona'];
    $columnas   = "p.*, e.*, a.*, c.*, p.fecha_sistema AS fecha_persona";
    $tabla      = "gen_personas AS p INNER JOIN ges_empleados AS e ON e.id_persona=p.id_persona INNER JOIN gen_areas_trabajo AS a "
        . "ON e.id_area_trabajo=a.id_area_trabajo INNER JOIN gen_cargos AS c ON e.id_cargo=c.id_cargo";
    $condicion = "p.id_persona = :v1";
    $valores   = array(":v1" => $id_persona);
    $rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

    echo json_encode($rs);

}

function actualizarRegistro()
{
    $conn       = new DBManejador();
    $values     = parametros();
    $id_empresa = session::getAttribute('IDEMPRESA');
    $conexion   = $conn->getConexion();
    $id_persona = $_REQUEST['id_persona'];

    try {

        $columnas  = "*";
        $tabla     = "seg_usuarios";
        $condicion = "usuario=:v1 AND id_persona<>:v2";
        $valores   = array(":v1" => $values['correoElectronico'], ":v2" => $id_persona);
        $rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
        if ($rs) {
            //el correo electronico ya existe
            throw new Exception('El correo ya existe');
        }

    } catch (Exception $ex) {
        echo -5;
        exit();
    }
    try {
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comenzar una transacción, desactivando el modo 'autocommit'
        $conexion->beginTransaction();

//         se registran los datos basicos de la persona
        $tabla  = "gen_personas";
        $campos = "id_tipo_documento=:v1, numero_documento=:v2, primer_nombre=:v3, "
            . "segundo_nombre=:v4, primer_apellido=:v5, segundo_apellido=:v6, email=:v7";
        $condicion = "id_persona=:v8";
        $valores   = array(
            ":v1" => $values['tipoDocumento'], ":v2"     => $values['numeroDocumento'], ":v3" => $values['primerNombre'],
            ":v4" => $values['segundoNombre'], ":v5"     => $values['primerApellido'], ":v6"  => $values['segundoApellido'],
            ":v7" => $values['correoElectronico'], ":v8" => $id_persona);
        $query = $conexion->prepare("UPDATE " . $tabla . " SET " . $campos . " WHERE " . $condicion);
        $query->execute($valores);

        // se registran datos  laborales de la persona
        $destino = "../../../Empresas/" . consultarDocumentoEmpresa($id_empresa) . "/imagenes";
        if (isset($_FILES['foto']['name'])) {
            $nombre_foto = $_FILES['foto']['name'];
            $tipo_foto   = $_FILES['foto']['type'];
            $tamano_foto = $_FILES['foto']['size'];
            $tmp_foto    = $_FILES['foto']['tmp_name'];
            $ruta_foto   = $destino . '/' . rand(1, 1000) . $nombre_foto;
            move_uploaded_file($tmp_foto, $ruta_foto);
        } else {
            $ruta_foto = $values['img_foto'];
        }
        $destino = "../../../Empresas/" . consultarDocumentoEmpresa($id_empresa) . "/firmas";
        if (isset($_FILES['firma']['name'])) {
            $nombre_firma = $_FILES['firma']['name'];
            $tipo_firma   = $_FILES['firma']['type'];
            $tamano_firma = $_FILES['firma']['size'];
            $tmp_firma    = $_FILES['firma']['tmp_name'];
            $ruta_firma   = $destino . '/' . rand(1, 1000) . $nombre_firma;
            move_uploaded_file($tmp_firma, $ruta_firma);
        } else {
            $ruta_firma = $values['img_firma'];
        }

        $jefe = 0;
        if ($values['jefeInmediato'] != "") {
            $jefe = $values['jefeInmediato'];
        }

        $sucursal = 0;
        if ($values['sucursal'] != "") {
            $sucursal = $values['sucursal'];
        }

        $tabla     = "ges_empleados";
        $condicion = "id_persona=:v1";

        $campos = "id_persona_jefe=:v2, url_foto=:v3, url_firma=:v4, id_cargo=:v5,"
            . " id_area_trabajo=:v6, id_sucursal=:v7";
        $valores = array(":v1" => $id_persona, ":v2" => $jefe, ":v3"            => $ruta_foto,
            ":v4"                  => $ruta_firma, ":v5" => $values['cargo'], ":v6" => $values['area'], ":v7" => $sucursal);
        $query = $conexion->prepare("UPDATE " . $tabla . " SET " . $campos . " WHERE " . $condicion);
        $query->execute($valores);

        // Consignar los cambios
        $conexion->commit();
        echo 3;

    } catch (Exception $e) {
        echo -3; //no se guardaron los datos
        // Reconocer el error y revertir los cambios
        $conexion->rollBack();
    }
}

function eliminarRegistro()
{
    $conn     = new DBManejador();
    $conexion = $conn->getConexion();

    $id = $_REQUEST['id_persona'];

    try {
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comenzar una transacción, desactivando el modo 'autocommit'
        $conexion->beginTransaction();
        $tabla     = 'ges_empleados';
        $campos    = 'fecha_eliminado=:v1 , estado_empleado=:v2';
        $valores   = array(':v1' => date('Y-m-d'), ':v2' => 0, ':v3' => $id);
        $condicion = 'id_persona=:v3';
        $query     = $conexion->prepare("UPDATE " . $tabla . " SET " . $campos . " WHERE " . $condicion);
        $query->execute($valores);

        $tabla     = 'seg_usuarios';
        $campos    = 'estado=:v1';
        $valores   = array(':v1' => 0, ':v2' => $id);
        $condicion = 'id_persona=:v2';
        $query     = $conexion->prepare("UPDATE " . $tabla . " SET " . $campos . " WHERE " . $condicion);
        $query->execute($valores);

        // Consignar los cambios
        $conexion->commit();
        echo 1;
    } catch (Exception $e) {
        echo 0; //no se guardaron los datos
        // Reconocer el error y revertir los cambios
        $conexion->rollBack();
    }

}
