 
<?php 
include_once("../src/DBManejador.php");
$manejador = new DBManejador();

$tabla = "pruebas";
$Id = $_POST["id_prueba"];

$campos =  "" . $nombre . "," . $apellido ."," . $direccion . "";

$resultado =  $manejador->eliminar($tabla,"id_persona" + $Id);

if($resultado > 0 )
echo "Grabo";
else 
echo "Error";
?> 
eliminar($tabla, $condicion, $valores)