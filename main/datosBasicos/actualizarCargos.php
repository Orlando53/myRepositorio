<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-25-07
 * @objetivo: Actualizar cargos
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

$id_empresa = $_SESSION['IDEMPRESA'];
$id_cargo   = $_REQUEST['id_cargo'];

$respuesta = new stdClass();

$columnas  = "c.id_cargo, c.cargo, c.descripcion, c.id_jefe_inmediato, (cc.cargo) AS jefe";
$tabla     = "gen_cargos cc INNER JOIN gen_cargos c ON (cc.id_cargo = c.id_jefe_inmediato)";
$condicion = "c.id_empresa = :v1 AND c.id_cargo = :v2";

$columnas2  = "c.id_cargo, c.cargo, c.descripcion, c.id_jefe_inmediato, (c.cargo) AS jefe";
$tabla2     = "gen_cargos c";
$condicion2 = "c.id_empresa = :v3 AND c.id_cargo = :v4 AND c.id_jefe_inmediato = :v5";
$valores    = array(":v1" => $id_empresa, ":v2" => $id_cargo, ":v3" => $id_empresa, ":v4" => $id_cargo, ":v5" => '0');

$rs_act = $conn->consultarUnion($columnas, $tabla, $condicion, $columnas2, $tabla2, $condicion2, $valores);
echo json_encode($rs_act);
//consulta los cargos que reportan actuales

// $columnas3  = "c.id_cargo, c.cargo, cr.id_cargo_reporta, (SELECT cargo FROM gen_cargos WHERE cr.id_cargo_reporta = id_cargo) AS nombre_cargo_reporta";
// $tabla3     = "gen_cargo_reporta cr INNER JOIN gen_cargos c ON (c.id_cargo = cr.id_cargo)";
// $condicion3 = "c.id_cargo = :v1 AND c.id_empresa = :v2";
// $valores3   = array(":v1" => $id_cargo, ":v2" => $id_empresa);

// $rs_act2 = $conn->consultarCondicion($columnas3, $tabla3, $condicion3, $valores3);

// //recorre el array  verticalmente, mostrando los valores de nombre_cargo_reporta separados por coma
// $cargoreporta = implode(', ', array_map(function ($entry) {
//     return $entry['nombre_cargo_reporta'];
// }, $rs_act2));

// $idcargoreporta = implode(', ', array_map(function ($entry) {
//     return $entry['id_cargo_reporta'];
// }, $rs_act2));

// echo '<div class="nvt-input-group two-third">';
// echo '<input id="txtNombreAct" name="nombreAct" type="text" value="' . $rs_act[0]["cargo"] . '">';
// echo '<input type="hidden" name="id_cargo" id="id_cargo" value="' . $rs_act[0]["id_cargo"] . '">';
// echo '<span class="bar"></span>';
// echo '<label for="txtNombre">Nombre del cargo</label>';
// echo '</input>';

// echo '</div>';
// echo '<div class="nvt-input-group third">';
// echo '<select name = "selJefeAct[]" id="selJefeAct" class="selectpicker" title="Seleccione"></select>';
// echo '<label for="selJefe">Jefe Inmediato</label>';
// echo '</div>';

// echo '<div class="nvt-input-group full">';
// echo '<textarea name ="descripcionAct" id="txtDescripcionAct">' . $rs_act[0]["descripcion"] . '</textarea>';
// echo '<label for="txtDescripcion">Descripción del cargo</label>';
// echo '<p class="charcount"></p>';
// echo '</div>';
