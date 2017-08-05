<!--

 @Autor: Juan Diego Ninco Collazos

 @fecha:      julio 19 de 2017

 @Objetivo: vista del perfil del usuario logueado

 -->

<?php
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if(!session::existsAttribute("LOGEADO")){
	header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
        </title>
    </head>
    <body>
        <table>
            <tr><td colspan="2"><h3>Datos de usuario</h3></td></tr>
            <tr>
                <td>
                    <strong>Nombre: </strong>
                </td>
                <td>
                <?php echo $_SESSION['NOMBRE'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Usuario: </strong>
                </td>
                <td>
                   <?php echo $_SESSION['USUARIO'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Rol: </strong>
                </td>
                <td>
                <?php echo $_SESSION['ROL'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Fecha inicio: </strong>
                </td>
                <td>
                <?php echo $_SESSION['fecha_inicio'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Fecha fin: </strong>
                </td>
                <td>
                <?php echo $_SESSION['fecha_fin'] ?>
                </td>
            </tr>
        </table>
    </body>
</html>