<?php

/*
 * @autor: Jose Eric Castro Cuadrado
 * @fecha: 2017-08-01
 * @objetivo: Actualizar los estados de la tabla gen_control_pro_inicio
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

if (!isset($_REQUEST['paso'])) {
    return;
}
$paso_actual    = $_REQUEST['paso']; //paso2
$paso_siguiente = 'paso' . ((substr($paso_actual, -1)) + 1); //paso3
$id_empresa     = $_SESSION['IDEMPRESA'];

$tabla     = "gen_control_pro_inicio";
$campos    = '' . $paso_actual . ' = :v1, ' . $paso_siguiente . ' = :v2';
$condicion = "id_empresa = :v3";
$valores   = array(":v1" => 1, ":v2" => 0, ":v3" => $id_empresa);

$rs_act = $conn->actualizar($tabla, $campos, $valores, $condicion);
