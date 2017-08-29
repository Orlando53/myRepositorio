<?php 
date_default_timezone_set('America/Bogota');
error_reporting(E_ERROR | E_PARSE);
@session_start();
echo $_SESSION['DOMINIO'];
//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

/* $URL = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$URL = substr($URL, 0, -17); */

include_once "../rsc/session.php";





/* try{
	$user = "sstnvs_sgsst";
	$pass = "abc123456";
    $conex = new PDO("mysql:host=localhost; dbname=sstnvs_dbsstplus","$user" ,"$pass" );
    $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	echo 'ERROR: ' . $e->getMessage();
}   

echo $conex;
try {
	$sql = "select * from seg_usuarios";
	$rs = $conex->prepare($statement);
	$rs->execute();
	echo $rs->rowCount();
	$row = $rs->fetchAll(PDO::FETCH_ASSOC);
	
} catch (Exception $e) {
	echo $e->getMessage();
} */


?>