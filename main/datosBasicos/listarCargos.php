<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-24-07
 * @objetivo: Mostrar cargos
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
//$id_empresa = '1';
$respuesta = new stdClass();

$columnas  = "c.id_cargo, c.cargo, c.descripcion, (cc.cargo) AS jefe";
$tabla     = "gen_cargos cc INNER JOIN gen_cargos c ON (cc.id_cargo = c.id_jefe_inmediato)";
$condicion = "c.id_empresa = :v1 AND c.estado = :v2";
//$valores   = array(":v1" => $id_empresa, ":v2" => '1');

$columnas2  = "c.id_cargo, c.cargo, c.descripcion, (c.cargo) AS jefe";
$tabla2     = "gen_cargos c";
$condicion2 = "c.id_empresa = :v3 AND c.estado = :v4 AND c.id_jefe_inmediato = :v5";
$valores    = array(":v1" => $id_empresa, ":v2" => '1', ":v3" => $id_empresa, ":v4" => '1', ":v5" => '0');

$rs_consultar = $conn->consultarUnion($columnas, $tabla, $condicion, $columnas2, $tabla2, $condicion2, $valores);

$contador = 0;

//echo '<table id="tabla" class="table table-responsive nvt-table">';
//echo '<tr><td>#</td><td>Nombre</td><td>Descripción</td></tr>';
while ($contador < count($rs_consultar)) {

    echo '<tr><td>';

    echo '<div class="checkbox-input"><label for="checkbox">
    <input type="checkbox"  name="IdsCargos[]" id="check' . $contador . '" value="' . $rs_consultar[$contador]["id_cargo"] . '">' . $rs_consultar[$contador]["id_cargo"] . ' </label></div>';
    echo '</td>';
    echo '<td>' . $rs_consultar[$contador]["cargo"] . '</td>';
    echo '<td>' . $rs_consultar[$contador]["descripcion"] . '</td>';
    echo '<td>' . $rs_consultar[$contador]["jefe"] . '</td>';
    $contador++;

}

//echo '</table>';

//header("location:registrarAreasTrabajo.php?contador=$contador&consultar=$rs_consultar");
