<?php
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once 'email/envio.php';
$v1 = $_REQUEST['v1'];
$v2 = $_REQUEST['v2'];
$v3 = $_REQUEST['v3'];
$v4 = $_REQUEST['v4'];

$envio = new envio();
$flag = $envio->enviarCorreo($v6, $v4, $mensaje, $asunto);
if($flag != 1){
    //grabar log
}

?>

