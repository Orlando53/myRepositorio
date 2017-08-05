<?php
/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-27-07
 * @objetivo: Mostrar sucursales
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
$respuesta  = new stdClass();

$columnas  = "*";
$tabla     = "gen_sucursales";
$condicion = "id_empresa = :v1 AND estado = :v2";
$valores   = array(":v1" => $id_empresa, ":v2" => '1');

$rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);
$contador     = 0;

//echo '<table id="tabla" class="table table-responsive nvt-table">';
//echo '<tr><td>#</td><td>Nombre</td><td>Descripción</td></tr>';
while ($contador < count($rs_consultar)) {

    echo '<tr><td>';

    echo '<div class="checkbox-input"><label for="checkbox">
    <input type="checkbox"  name="IdsSucursales[]" id="check' . $contador . '" value="' . $rs_consultar[$contador]["id_sucursal"] . '">' . $rs_consultar[$contador]["id_sucursal"] . ' </label></div>';
    echo '</td>';
    echo '<td>' . $rs_consultar[$contador]["prefijo"] . '</td>';
    echo '<td>' . $rs_consultar[$contador]["razon_social"] . '</td>';
    $contador++;

}

//echo '</table>';

//header("location:registrarAreasTrabajo.php?contador=$contador&consultar=$rs_consultar");
