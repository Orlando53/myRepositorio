 
<?php 
include_once("../src/DBManejador.php");
$manejador = new DBManejador();

$tabla = "pruebas";
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$direccion = $_POST["direccion"];
$Id = $_POST["id_prueba"];

$columnas = "nombre,apellido,direccion";
$campos =  "" . $nombre . "," . $apellido ."," . $direccion . "";

$resultado =  $manejador->actualizar($tabla,$columnas,$campos,"id_pruebas = " + $Id);

if($resultado > 0 )
echo "Grabo";
else 
echo "Error";
?>