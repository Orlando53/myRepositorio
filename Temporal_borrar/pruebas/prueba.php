<?php
require_once "./../rsc/DBManejador.php";

$db = new DBManejador() ; 

var_dump(in_array('mod_rewrite', apache_get_modules()));
?>