<?php

/*
 * @autor:         jose erick
 * @fecha:         25-07-2017
 * @objetivo:      acciones para sucursales de la empresa
 */

@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
require_once '../../rsc/session.php';
if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}
?>


<head>
    <meta charset="utf-8">
    <title>Sucursales Empresa</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap-select.css" type="text/css"/>
	<link rel="stylesheet" href="../../css/nvst.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">
	<link href="../../css/validationEngine.jquery.css" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="32x32" href="../../../images/favicon-32x32.png">
	<link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
		<div class="row">
			<div class="col-md-1 col-md-offset-1 goback"><a href="../index.php"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
		<form id="frmOperaciones" method="post">
			<div class="col-md-8 floater">
				<h2>Sedes o Sucursales</h2>
					<div class="nvt-input-group third">
						<input type="text" name="Nombre" id="search" placeholder="Buscar por Nombre ...">
						<span class="bar"></span>
						<label for="search">Buscar</label>
					</div>
					<div class="nvt-button-group two-third right-align">
						<input type="button" id = "btnNuevo" class="nvt-btn nvt-btn-primary" value="Nuevo" >
						<!-- data-toggle="modal" data-target="#insertarModal" -->
						<input type="button" class="nvt-btn nvt-btn-primary" value="Eliminar" id="btnEliminar">
						<input type="button" class="nvt-btn nvt-btn-primary" value="Modificar" id="btnModificar" data-toggle="Modal" data-target="#actualizarModal">
						<!-- <input type="button" class="nvt-btn nvt-btn-primary" value="Exportar"> -->
						<a href="#"><img src="../../media/icon/check.png" class="form-check" id="imgCheck"></a>
					</div>
					<table class="table table-striped table-bordered" id="tabla">
	 					<thead>
                            <tr>
                                <th>
                                    <div class="checkbox-input"> <input type="checkbox"  name="" id="" value="" onclick="marcar(this);">#</div>
                                </th>
                                <th>Prefijo</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'listarSucursales.php';?>
                        </tbody>
					</table>
			</div>
		</form>
			<div class="col-md-1"><a href="#ayuda" data-toggle="modal" data-target="#ayudaModal"><img src="../../media/icon/help.png"  data-toggle="tooltip" data-placement="bottom" title="Ayuda"></a></div>
		</div>

		<!-- Modal Insertar -->
		<div class="modal fade" id="insertarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Registrar Nueva Sucursal</h4>
		      </div>
		      <div class="modal-body">
		      <!--Modal Body-->
		        <form id="frmDatosSucursal"  method="post">
					<div class="nvt-input-group half">
						<input type="text" name="Prefijo" id="Prefijo" class="validate[required]">
						<span class="bar"></span>
						<label for="txtPrefijo">Prefijo</label>
					</div>
					<div class="nvt-input-group half">
						<input type="text" name="nombre" id="nombre" class="validate[required]">
						<span class="bar"></span>
						<label for="txtNombre">Nombre</label>
					</div>
			<!-- 		<div class="nvt-input-group third">
                        <select name="tipoIdentificacion" id="tipoIdentificacion" class="selectpicker validate[required]" title="Selecciona Uno">
                            <option >Nit</option>
                            <option >Cédula de Ciudadanía</option>
                            <option >Cédula de Extrangería</option>
                        </select>
                        <label for="tipoIdentificacion">Tipo de Identificación</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="text" name="numeroIdentificacion" id="numeroIdentificacion" class="validate[required, custom[integer],min[1]]">
                        <span class="bar"></span>
                        <label for="numeroIdentificacion">Numero de Identificación</label>
                    </div>
					<div class="nvt-input-group third" style="text-align: center;">
                        <h5>Logo</h5>
                        <div class="file-input">
                            <img src="#" id="logoImg">
                            <label for="logo">cambiar</label>
                            <input type="file" name="" class="imgFile validate[required]" id="logo" accept="image/jpg,image/png">
                        </div>
                        <input type="button" class="nvt-btn nvt-btn-danger logoClear" value="X">
                    </div> -->
                    <div class="nvt-input-group third">
                        <input type="number"  name="numTelefono" id="numTelefono" class="validate[required, custom[phone]]" />
                        <span class="bar"></span>
                        <label for="numTelefono">Telefono</label>
                    </div><div class="nvt-input-group third">
                        <input type="text" name="direccion" id="direccion" class="validate[required]" readonly/>
                        <span class="bar"></span>
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="email" name="email" id="email" class="validate[required, custom[email]]">
                        <span class="bar"></span>
                        <label for="email">Correo Electrónico</label>
                    </div>
					<!-- <div class="nvt-input-group half">
						<select id="selCargosAsociados" class="selectpicker validate[required]" multiple title="Seleccione">
							<option>Gerente</option>
							<option>Programador</option>
							<option>Mensajero</option>
						</select>
						<label for="selCargosAsociados">Cargos Asociados</label>
					</div>
					<div class="nvt-input-group half">
						<select id="selAreasAsociadas" class="selectpicker validate[required]" multiple title="Seleccione">
							<option>Desarrollo</option>
							<option>Calidad</option>
						</select>
						<label for="selAreasAsociadas">Áreas Asociadas</label>
					</div> -->
					<div class="nvt-input-group half">
						<select id="selDPTO" name="selDPTO[]" class="selectpicker validate[required]" title="Seleccione">
							<option>Huila</option>
						</select>
						<label for="selDPTO">Departamento</label>
					</div>
					<div class="nvt-input-group half">
						<select id="selMPIO" name="selMPIO[]" class="selectpicker validate[required]" title="Seleccione">
							<option>Neiva</option>
						</select>
						<label for="selMPIO">Municipio</label>
					</div>
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="nvt-btn nvt-btn-primary" id="btn-guardarSucursal">Guardar Datos</button>
		      </div>
		    </div>
		  </div>
		</div>

					<!-- Modal Actualizar -->
		<div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Actualizar Sucursal</h4>
		      </div>
		      <div class="modal-body">
		      <!--Modal Body-->
		        <form id="frmActualizarSucursal"  method="post">
					<div class="nvt-input-group half">
						<input type="hidden" name="idSucursal" id="idSucursal" class="">
						<input type="text" name="PrefijoAct" id="PrefijoAct" class="validate[required]">
						<span class="bar"></span>
						<label for="PrefijoAct">Prefijo</label>
					</div>
					<div class="nvt-input-group half">
						<input type="text" name="nombreAct" id="nombreAct" class="validate[required]">
						<span class="bar"></span>
						<label for="nombreAct">Nombre</label>
					</div>
					<!-- <div class="nvt-input-group third">
                        <select name="tipoIdentificacionAct" id="tipoIdentificacionAct" class="selectpicker validate[required]" title="Selecciona Uno">
                            <option >Nit</option>
                            <option >Cédula de Ciudadanía</option>
                            <option >Cédula de Extrangería</option>
                        </select>
                        <label for="tipoIdentificacionAct">Tipo de Identificación</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="text" name="numeroIdentificacionAct" id="numeroIdentificacionAct" class="validate[required, custom[integer],min[1]]">
                        <span class="bar"></span>
                        <label for="numeroIdentificacionAct">Numero de Identificación</label>
                    </div>
					<div class="nvt-input-group third" style="text-align: center;">
                        <h5>Logo</h5>
                        <div class="file-input">
                            <img src="#" id="logoImg">
                            <label for="logoAct">cambiar</label>
                            <input type="file" name="logoAct" class="imgFile validate[required]" id="logoAct" accept="image/jpg,image/png">
                        </div>
                        <input type="button" class="nvt-btn nvt-btn-danger logoClear" value="X">
                    </div> -->
                    <div class="nvt-input-group third">
                        <input type="number"  name="numTelefonoAct" id="numTelefonoAct" class="validate[required, custom[phone]]" />
                        <span class="bar"></span>
                        <label for="numTelefonoAct">Telefono</label>
                    </div><div class="nvt-input-group third">
                        <input type="text" name="direccionAct" id="direccionAct" class="validate[required]" readonly/>
                        <span class="bar"></span>
                        <label for="direccionAct">Dirección</label>
                    </div>
                    <div class="nvt-input-group third">
                        <input type="email" name="emailAct" id="emailAct" class="validate[required, custom[email]]">
                        <span class="bar"></span>
                        <label for="emailAct">Correo Electrónico</label>
                    </div>
					<div class="nvt-input-group half">
						<select id="selDPTOAct" name="selDPTOAct[]" class="selectpicker validate[required]" title="Seleccione">
							<option>Huila</option>
						</select>
						<label for="selDPTOAct">Departamento</label>
					</div>
					<div class="nvt-input-group half">
						<select id="selMPIOAct" name="selMPIOAct[]" class="selectpicker validate[required]" title="Seleccione">
							<!-- <option>Neiva</option> -->
						</select>
						<label for="selMPIOAct">Municipio</label>
					</div>
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="nvt-btn nvt-btn-primary" id="btn-actualizarSucursal">Actualizar</button>
		      </div>
		    </div>
		  </div>
		</div>






		<div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Dirección</h4>
                    </div>
                    <div class="modal-body" id="div-direccion">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnAceptar-dir" type="button" class="nvt-btn nvt-btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

		<!-- Modal Ayuda -->
		<div class="modal fade" id="ayudaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
		      </div>
		      <div class="modal-body">
		      <!--Modal Body-->
		        Información de Ayuda Referente a Esta Vista.
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
<script src="../../js/jquery-3.2.1.min.js"></script>
<script src = "../../js/jquery-ui.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src = "../../js/alertify.js"></script>
<script src="../../js/bootstrap-select.js"></script>
<script src="../../js/nvt.js"></script>
<script src="../../js/jquery.jCombo.js"></script>
<script src="../../js/jquery.dataTables.js"></script>
<script src="../../js/tables.js"></script>
<script src="../../js/jquery.validationEngine.js"></script>
<script src="../../js/languages/jquery.validationEngine-es.js"></script>
<script src = "../../js/jquery.funciones.js"></script>
<script src="js/sucursales.js"></script>
</body>