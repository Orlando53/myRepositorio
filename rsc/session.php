<?php

class session
{
    public static function existsAttribute($name)
    {
        $rpta = false;
        if (isset($_SESSION[$name])) {
            $rpta = true;
        }
        return $rpta;
    }

    public static function getAttribute($name)
    {
        $rpta = null;
        if (self::existsAttribute($name)) {
            $rpta = $_SESSION[$name];
        }
        return $rpta;
    }

    public static function setAttribute($name, $valor)
    {
        $_SESSION[$name] = $valor;
    }

    public static function removeAttribute($name)
    {
        if (self::existsAttribute($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function valida(){
    	$ultima = session::getAttribute("ULTIMA");
		$ahora = date("Y-n-j H:i:s");
		$tiempo_transcurrido = (strtotime($ahora)-strtotime($ultima));
		if($tiempo_transcurrido >= 600){
			session_destroy();
			return false;
		}
    	return true;
    }
    
    public static function logout()
    {
        session_start();
        unset($_SESSION["IDUSUARIO"]);
        unset($_SESSION["USUARIO"]);
        unset($_SESSION["CAMBIO"]);
        unset($_SESSION["IDROL"]);
        unset($_SESSION["IDROL"]);
        unset($_SESSION["RAIZ"]);
        unset($_SESSION["IDEMPRESA"]);
        unset($_SESSION["LOGEADO"]);
        unset($_SESSION["NOMBRE"]);
        unset($_SESSION["ROL"]);
        unset($_SESSION["IDPERSONA"]);
        unset($_SESSION["fecha_inicio"]);
        unset($_SESSION["fecha_fin"]);
        session_destroy();
        header('Location: ../../login/index.php');
        exit;
    }
}
