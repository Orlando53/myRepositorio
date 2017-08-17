
<?php

/*
 * @autor:         Juan Diego Ninco Collazos
 * @fecha:         24-07-2017
 * @objetivo:      Registrar usuarios
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Usuario</title>
</head>
<body>
 <form  id="frmUsuario" method="POST">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <p id="pFormularioUsuario">Registrar Nuevo Usuario</p></h4>
              </div>
              <div class="modal-body">
              <!--Modal Body-->

                                            <div class="nvt-input-group third">
                                                <input type="text" name="txtNombre1" id="txtNombre1" class=" validate[required]">
                                                <span class="bar"></span>
                                                <label for="txtNombre1">Primer nombre</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <input type="text" name="txtNombre2"  id="txtNombre2">
                                                <span class="bar"></span>
                                                <label for="txtNombre2">Segundo nombre</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <input type="text" name="txtApellido1" id="txtApellido1"  class="  validate[required]">
                                                <span class="bar"></span>
                                                <label for="txtApellido1">Primer apellido</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <input type="text" name="txtApellido2" id="txtApellido2">
                                                <span class="bar"></span>
                                                <label for="txtApellido2">Segundo apellido</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <select id="selTipoDocumento"  name="selTipoDocumento"  title="Seleccione" class="selectpicker validate[required]" data-live-search="true">
                                                </select>
                                                <label for="selTipoDocumento" >Tipo de Documento</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <input type="number" name="numDocumento" id="numDocumento" class="validate[required],custom[integer],min[0]">
                                                <span class="bar"></span>
                                                <label for="numDocumento">Número de Documento</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <input type="email" name="email" id="email" class="validate[required],custom[email]">
                                                <span class="bar"></span>
                                                <label for="email">Correo Electrónico</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <select id="selJefe" name="selJefe" class="selectpicker" title="Seleccione" data-live-search="true">

                                                </select>
                                                <label for="selJefe">Jefe Inmediato</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <select id="selCargo" name="selCargo" class="selectpicker validate[required]"  title="Seleccione" data-live-search="true">

                                                </select>
                                                <label for="selCargo">Cargo</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <select id="selArea" name="selArea" class="selectpicker validate[required]"   title="Seleccione" data-live-search="true">

                                                </select>
                                                <label for="selArea">Área</label>
                                            </div>
                                            <div class="nvt-input-group third">
                                                <select id="selSede" name="selSede" class="selectpicker" title="Seleccione" data-live-search="true">

                                                </select>
                                                <label for="selSede">Sede o Sucursal</label>
                                            </div>

                                            <input type="hidden" id="hid_foto">
                                            <input type="hidden" id="hid_firma">
                                            <div class="nvt-input-group half" style="text-align: center;">
                                                <h5>Foto</h5>
                                                <div class="file-input">
                                                    <img id="foto" src="../../media/image/placeholderPhoto.png">
                                                    <label for="fileFoto">Cambiar</label>
                                                    <input type="file" name="fileFoto" class="imgFile" id="fileFoto">
                                                </div><input type="button" class="nvt-btn nvt-btn-danger logoClear" value="X">
                                            </div>
                                            <div class="nvt-input-group half" style="text-align: center;">
                                                <h5>Firma</h5>
                                                <div class="file-input">
                                                    <img id="firma" src="../../media/image/placeholderPhoto.png">
                                                    <label for="fileFirma">Cambiar</label>
                                                    <input type="file" name="fileFirma" class="imgFile" id="fileFirma">
                                                </div><input type="button" class="nvt-btn nvt-btn-danger logoClear" value="X">
                                            </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="nvt-btn nvt-btn-primary" id="btnGuardarUsuario">Guardar Datos</button>
              </div>
              </form>
</body>
<script src="../../js/nvt.js"></script>
<script src="./js/accionesUsuario.js"></script>
