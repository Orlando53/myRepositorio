<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-24-07
 * @objetivo: Guardar Cargos
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
include_once '../../rsc/session.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit(0);
}
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}

$id_empresa  = $_SESSION['IDEMPRESA'];
$cargo       = mb_strtoupper($_POST['nombre']);
$descripcion = ucfirst($_POST['descripcion']);

$respuesta = new stdClass();

//convierte los datos del array a una cadena, separando cada uno por comas.
//$cargoreporta = implode(",", $cargo_reporta);

// for ($i = 0; $i < count($cargo_reporta); $i++) {
//     $cargoreporta = $cargo_reporta[$i];
// }

// for ($i = 0; $i < count($jefe_inmediato); $i++) {
//     $jefeinmediato = $jefe_inmediato[$i];
// }
$jefeinmediato = $_POST['selJefe'][0];

$columnasc  = "cargo";
$tablac     = "gen_cargos";
$condicionc = "cargo = :v1 AND id_empresa = :v2 AND estado = :v3";
$valoresc   = array(":v1" => $cargo, ":v2" => $id_empresa, ":v3" => '1');

$rs_c = $conn->consultarCondicion($columnasc, $tablac, $condicionc, $valoresc);

if (empty($rs_c)) {

    $tabla      = "gen_cargos";
    $columnas   = "id_empresa, id_jefe_inmediato, cargo, descripcion, estado";
    $campos     = ":v1, :v2, :v3, :v4, :v5";
    $valores    = array(":v1" => $id_empresa, ":v2" => $jefeinmediato, ":v3" => $cargo, ":v4" => $descripcion, ":v5" => '1');
    $rs_agregar = $conn->agregar($tabla, $columnas, $campos, $valores);

    $columnac1 = "id_cargo";
    $tablac1   = "gen_cargos";
    $rs_id     = $conn->consultarMax($columnac1, $tablac1);
    $id_cargo  = $rs_id[0]['id'];

    // if (empty($_POST['selReporta'])) {

    // } else {

    //     foreach ($_POST['selReporta'] as $cargoreporta) {

    //         if ($cargoreporta == 0) {} else {

    //             $tabla        = "gen_cargo_reporta";
    //             $columnas     = "id_cargo, id_cargo_reporta";
    //             $campos       = ":v1, :v2";
    //             $valores      = array(":v1" => $id_cargo, ":v2" => $cargoreporta);
    //             $rs_agregarcr = $conn->agregar($tabla, $columnas, $campos, $valores);
    //         }
    //     }
    //     echo $respuesta->mensaje = 'Cargo registrado';

    // }
    echo 1;
    //echo $respuesta->mensaje = 'Cargo registrado';
} else {
    echo 0;
    //echo $respuesta->mensaje = 'El cargo que intenta agregar ya se encuentra registrado.';

}
