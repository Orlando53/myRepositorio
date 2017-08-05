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

$id_empresa = $_SESSION['IDEMPRESA'];
$id_area    = $_POST['IdsAreas'][0];

$respuesta = new stdClass();

$columnas  = "id_area_trabajo, area_trabajo, descripcion";
$tabla     = "gen_areas_trabajo";
$condicion = "id_empresa = :v1 and id_area_trabajo = :v2";
$valores   = array(":v1" => $id_empresa, ":v2" => $id_area);

$rs_act = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

echo '<div class="nvt-input-group two-third">';

echo '<input type="hidden" name="idArea" id="idArea" value="' . $rs_act[0]["id_area_trabajo"] . '">';

echo '<input type="text" name="area_trabajo" id="txtNombre" class="validate[required]" value="' . $rs_act[0]["area_trabajo"] . '">';
echo '<span class="bar"></span>';
echo '<label for="nombre">Nombre</label>';
echo '</div>';
echo '<div class="nvt-input-group full">';
echo '<textarea name="descripcion" id="txtDescripcion" class="validate[required]">' . $rs_act[0]["descripcion"] . '</textarea>';
echo '<label for="descripcion">Descripción</label>';
echo '<p class="charcount"></p>';
echo '</div>';
