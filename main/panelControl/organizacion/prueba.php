<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-23-08
 * @objetivo: Actualizar empleados
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../../rsc/DBManejador.php';
include_once '../../../rsc/session.php';

$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../../index.php");
}

$id_empresa = '3';
$idempleado = '32';

$n1              = 'AMY';
$n2              = '';
$a1              = 'LEE';
$a2              = '';
$tipoDocumento   = '3';
$numeroDocumento = '342574';
$genero          = '';
$direccion       = '';
$dpto            = '';
$mpio            = '';
$telefono        = '555555';
$email           = 'amylee@evanescence.com';
$foto            = '';
$firma           = '';
$cargo           = '33';
$hv              = '';
$jefeInmediato   = '';
$area            = '39';
$sucursal        = '26';
$tipoVinculacion = '';
$eps             = '';
$afp             = '';
$arl             = '';

$administrador = '0';

$empleado = '0';

$jefe = '0';

$auditor = '0';

$activo = '0';

$fechaIngreso = '';
$fechaSalida  = '';

$columnas  = "id_persona";
$tabla     = "ges_empleados";
$condicion = "id_empresa = :v1 AND estado_empleado = :v2 AND id_empleado = :v3";
$valores   = array(":v1" => $id_empresa, ":v2" => '1', ":v3" => $idempleado);

$rs_1 = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

if ($rs_1) {
    // echo $id_empresa;
    // echo $rs_1[0]['id_persona'];
    $tabla     = "gen_personas";
    $campos    = "primer_nombre = :v1, segundo_nombre = :v2, primer_apellido = :v3, segundo_apellido = :v4, id_tipo_documento = :v5, numero_documento = :v6, email = :v7";
    $condicion = "id_persona = :v8";
    $valores   = array(":v1" => $n1, ":v2" => $n2, ":v3" => $a1, ":v4" => $a2, ":v5" => $tipoDocumento, ":v6" => $numeroDocumento, ":v7" => $email, ":v8" => $rs_1[0]['id_persona']);

    $rs_2 = $conn->actualizar($tabla, $campos, $valores, $condicion);

    if ($rs_2) {

        $documento_empresa = consultarDocumentoEmpresa($id_empresa);
        if ($documento_empresa == 0) {
            // sale del try catch
            throw new Exception('Error al consultar empresa');
        }

        // se guarada la foto
        $destino   = "../../../Empresas/" . $documento_empresa . "/imagenes/";
        $ruta_foto = "";
        if (isset($_FILES['foto']['name'])) {
            $nombre_foto = eliminarTildes(rand(1, 3000) . $_FILES['foto']['name']);
            $tipo_foto   = $_FILES['foto']['type'];
            $tamano_foto = $_FILES['foto']['size'];
            $tmp_foto    = $_FILES['foto']['tmp_name'];
            $ruta        = $destino . $nombre_foto;
            // si se mueve el archivo
            if (move_uploaded_file($tmp_foto, $ruta)) {
                $ruta_foto = $nombre_foto;
            } else {
                // sale del try catch
                throw new Exception('Error al subir archivo');
            }
        }
        // se guarda la firma
        $destino    = "../../../Empresas/" . $documento_empresa . "/firmas/";
        $ruta_firma = "";
        if (isset($_FILES['firma']['name'])) {
            $nombre_firma = eliminarTildes(rand(1, 3000) . $_FILES['firma']['name']);
            $tipo_firma   = $_FILES['firma']['type'];
            $tamano_firma = $_FILES['firma']['size'];
            $tmp_firma    = $_FILES['firma']['tmp_name'];
            $ruta         = $destino . $nombre_firma;
            // si se mueve el archivo
            if (move_uploaded_file($tmp_firma, $ruta)) {
                $ruta_firma = $nombre_firma;
            } else {
                // sale del try catch
                throw new Exception('Error al subir archivo');
            }
        }

        // se guarda la hoja de vida
        $destino = "../../../Empresas/" . $documento_empresa . "hojas_vida/";
        $ruta_hv = "";
        if (isset($_FILES['hv']['name'])) {
            $nombre_hv = eliminarTildes(rand(1, 3000) . $_FILES['hv']['name']);
            $tipo_hv   = $_FILES['hv']['type'];
            $tamano_hv = $_FILES['hv']['size'];
            $tmp_hv    = $_FILES['hv']['tmp_name'];
            $ruta      = $destino . $nombre_hv;
            // si se mueve el archivo
            if (move_uploaded_file($tmp_hv, $ruta)) {
                $ruta_hv = $nombre_hv;
            } else {
                // sale del try catch
                throw new Exception('Error al subir archivo');
            }
        }

        // $tabla = 'ges_empleados';
        // $condicion = "id_empleado = 1 AND id_empresa = 2 AND id_persona = 3";
        // $valores = array(":v1" => $idempleado, ":v2" => $id_empresa, ":v3" => $rs_1[0]['id_persona']);
        // $rs_e = $conn->eliminar($tabla, $condicion, $valores);

        $tabla     = "ges_empleados";
        $campos    = "id_genero = :v1, direccion_residencia = :v2, id_departamento_residencia  = :v3, id_municipio_residencia  = :v4, telefono_1 = :v5, url_foto = :v6, url_firma = :v7, url_hv = :v8, id_persona_jefe = :v9, id_cargo = :v10, id_area_trabajo = :v11, id_sucursal = :v12, id_tipo_vinculacion = :v13, id_eps = :v14, id_afp = :v15, id_arl = :v16, administrador = :v17, empleado = :v18, jefe = :v19, auditor = :v20, estado_empleado = :v21, fecha_ingreso = :v22, fecha_eliminado = :v23";
        $condicion = "id_empleado = :v24 AND id_empresa = :v25 AND id_persona = :v26";
        $valores2  = array(":v1" => $genero, ":v2" => $direccion, ":v3" => $dpto, ":v4" => $mpio, ":v5" => $telefono, ":v6" => $ruta_foto, ":v7" => $ruta_firma, ":v8" => $ruta_hv, ":v9" => $jefeInmediato, ":v10" => $cargo, ":v11" => $area, ":v12" => $sucursal, ":v13" => $tipoVinculacion, ":v14" => $eps, ":v15" => $afp, ":v16" => $arl, ":v17" => $administrador, ":v18" => $empleado, ":v19" => $jefe, ":v20" => $auditor, ":v21" => $activo, ":v22" => $fechaIngreso, ":v23" => $fechaSalida, ":v24" => $idempleado, ":v25" => $id_empresa, ":v26" => $rs_1[0]['id_persona']);
        echo json_encode($valores2);
        $rs_3 = $conn->actualizar($tabla, $campos, $valores2, $condicion);
        if ($rs_3) {
            echo 1;
        } else {
            echo 0;
        }
    } else {}

} else {

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

//consulta y retorna el numero de documento de la empresa segun el id de la misma que se recibe como parametro
function consultarDocumentoEmpresa($id_empresa)
{

    $conn      = new DBManejador();
    $columnas  = "numero_documento";
    $tabla     = "gen_empresas";
    $condicion = "id_empresa=:v1";
    $valores   = array(":v1" => $id_empresa);
    $rs        = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
    // si ha retornado un valor
    if ($rs) {
        foreach ($rs as $row) {
            return $row['numero_documento'];
        }
    } else {
        return 0; //error al consultar
    }
}
