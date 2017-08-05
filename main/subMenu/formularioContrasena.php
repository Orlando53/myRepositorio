<?php

/*
 * @Autor:       Juan Diego Ninco Collazos
 *
 * @fecha:       julio 21 de 2017
 *
 * @Objetivo:   actualizar la  contraseña del usuario que ha iniciado sesión
 *
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
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
        <form id="cambioContrasena">
        <div class="row">
            <div class="nvt-input-group full">
                <input class="text-uppercase validate[required]" id="contrasenaActual" type="password"/>
                <span class="bar">
                </span>
                <label for="clave_actual">
                    Contraseña actual
                </label>
            </div>
        </div>
        <div class="row">
            <div class="nvt-input-group full">
                <input class="text-uppercase validate[required]" id="contrasenaNueva" type="password"/>
                <span class="bar">
                </span>
                <label for="clave_nueva">
                    Nueva Contraseña
                </label>
            </div>
        </div>
        <div class="row">
            <div class="nvt-input-group full">
                <input class="text-uppercase validate[required]" id="contrasenaConfirmada" type="password"/>
                <span class="bar">
                </span>
                <label for="confirmar_clave">
                    Confirmar Contraseña
                </label>
            </div>
        </div>
        <button class="nvt-btn nvt-btn-primary" onclick="cambiar_clave()" type="button">
            Guardar cambios
        </button>
        </form>
    </body>
</html>
