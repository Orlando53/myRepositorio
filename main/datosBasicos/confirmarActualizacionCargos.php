<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-15-07
 * @objetivo: Actualizar áreas de trabajo
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
$id_cargo    = $_POST['id_cargo'];
$cargo       = strtoupper($_POST['nombreAct']);
$descripcion = $_POST['descripcionAct'];

$id_jefe_inmediato = $_POST['selJefeAct'][0];
if ($id_jefe_inmediato == '') {

    $id_jefe_inmediato = $_POST['id_jefe_inmediato']; //actuales
}

$respuesta = new stdClass();

$tabla     = "gen_cargos";
$campos    = "id_jefe_inmediato = :v1, cargo = :v2, descripcion = :v3";
$condicion = "id_empresa = :v4 and id_cargo = :v5";
$valores   = array(":v1" => $id_jefe_inmediato, ":v2" => $cargo, ":v3" => $descripcion, ":v4" => $id_empresa, ":v5" => $id_cargo);

$rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);
// print_r(explode(',', $_POST['id_cargos_reportan'])); //actuales
// print_r($_POST['selReportaAct']); //nuevos

//si actuales y nuevos esetán vacíos no hace nada, de lo contrario, elimina los actuales y agrega los nuevos

// if (empty(explode(',', $_POST['id_cargos_reportan'])) && empty($_POST['selReportaAct'])) {
//     //$id_cargos_reportan = explode(',', $_POST['id_cargos_reportan']); //actuales

// } else {

//     foreach (explode(',', $_POST['id_cargos_reportan']) as $id_cargos_reportan) {
//         $tabla1     = "gen_cargo_reporta";
//         $condicion1 = "id_cargo = :v1";
//         $valores1   = array(":v1" => $id_cargo);
//         $rs_el      = $conn->eliminar($tabla1, $condicion1, $valores1);
//     }
//     foreach ($_POST['selReportaAct'] as $idcargosreportan) {

//         if ($idcargosreportan == 0) {} else {

//             $tabla2    = "gen_cargo_reporta";
//             $columnas2 = "id_cargo, id_cargo_reporta";
//             $campos2   = ":v1, :v2";
//             $valores2  = array(":v1" => $id_cargo, ":v2" => $idcargosreportan);
//             $rs_agr    = $conn->agregar($tabla2, $columnas2, $campos2, $valores2);
//         }
//     }
// }
echo 1;
//echo $respuesta->mensaje = 'Registro actualizado satisfactoriamente.';
