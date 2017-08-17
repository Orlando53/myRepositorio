
<?php

/*
 * @autor:         Jose Erick
 * @fecha:         21-07-2017
 * @objetivo:      acciones para areas de trabajo
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
	<meta charset="UTF-8">
	<title>Areas de trabajo</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap-multiselect.css" type="text/css"/>
	<link rel="stylesheet" href="../../css/nvst.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/validationEngine.jquery.css">
	<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">
	<link rel="icon" type="image/png" sizes="32x32" href="../../../images/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.core.css">
    <link rel="stylesheet" type="text/css" href="../../css/alertify.default.css">
	<link rel="stylesheet" type="text/css" href="shadowbox.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" content="minimum-scale=0.75, maximum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata|Oswald:300,400,700|Roboto:300,400,400i,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,900|Roboto+Condensed:300,400,700" rel="stylesheet">
</head>
<body>
		<div class="row">
			<div class="col-md-1 col-md-offset-1 goback"><a href="../index.php"><img src="../../media/icon/back.png"  data-toggle="tooltip" data-placement="bottom" title="Volver"></a></div>
			<form id="frmOperaciones" method="post">
			<div class="col-md-8 floater ">
				<h2>Áreas de Trabajo</h2>
					<div class="nvt-input-group third">
						<input type="text" name="Nombre" id="search" placeholder="Buscar por Nombre ...">
						<span class="bar"></span>
						<label for="search">Buscar</label>
					</div>
					<div class="nvt-button-group two-third right-align">
						<input type="button" class="nvt-btn nvt-btn-primary" value="Nuevo" data-toggle="modal" data-target="#insertarModal">
						<input type="button" class="nvt-btn nvt-btn-primary" value="Eliminar" onclick = "this.form.action = 'eliminarAreasTrabajo.php'" id="btnEliminar">
						<input type="button" class="nvt-btn nvt-btn-primary" value="Modificar" id="btnModificar" onclick = "this.form.action = 'actualizarAreasTrabajo.php'">
						<!-- <input type="button" class="nvt-btn nvt-btn-primary" value="Exportar" id="btnExportar"> -->
						<a href="#"><img src="../../media/icon/check.png" class="form-check" id="imgCheck"></a>
					</div>
					<table id="tabla" class="table table-striped table-bordered">
 						<thead>
							<tr>
								<th>
									<div class="checkbox-input"> <input type="checkbox"  name="" id="" value="" onclick="marcar(this);">#</div>
								</th>
								<th>Nombre</th>
								<th>Descripción</th>
							</tr>
 						</thead>
 						<tbody>
							<?php include 'listarAreasTrabajo.php';?>
						</tbody>
					</table>
			</div>
			</form>
			<div class="col-md-1">
			<!--href="#ayuda" data-toggle="modal" data-target="#ayudaModal" -->
				<a rel="shadowbox;width=405;height=340;" title="Shakira" href="http://www.youtube.com/v/h5jduAtpClk">
					<img src="../../media/icon/help.png"  data-toggle="tooltip" data-placement="bottom" title="Ayuda">
				</a>
			</div>

		</div>

		<!-- Modal Insertar -->
		<div class="modal fade" id="insertarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		  <!-- action="guardarAreasTrabajo" -->
		  	<form id="frmAreasTrabajo"  method="post">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="actualizar();"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Registro Áreas de Trabajo</h4>
			      </div>
			      <div class="modal-body">
			      <!--Modal Body-->

					  <div class="nvt-input-group two-third">
					  <input type="text" name="nombre" id="txtNombre" class="validate[required]">
					  <span class="bar"></span>
					  <label for="nombre">Nombre</label>
					  </div>
					  <div class="nvt-input-group full">
					  <textarea name="descripcion" id="txtDescripcion" class="validate[required]"></textarea>
					  <label for="descripcion">Descripción</label>
					  <p class="charcount"></p>
					  </div>
					  <div id="cargando" align="center"></div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal" onclick="actualizar();">Cerrar</button>
			        <button type="button" class="nvt-btn nvt-btn-primary" id="btn-guardarAreasTrabajo">Guardar Datos</button>
			      </div>
			    </div>
		    </form>
		  </div>
		</div>
		<!-- Modal Eliminar -->
		<div class="modal fade" id="cargandoElimina" align="center" role="dialog"></div>
		<!-- Modal Actualizar -->
		<div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		  <!-- action="guardarAreasTrabajo" -->
		  	<form id="frmActualizarArea"  method="post">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button onclick="actualizar();" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Actualización Áreas de Trabajo</h4>
			      </div>
			      <div class="modal-body">

			    	<div id="respuesta"></div>
			    	<div id="cargandoActualiza" align="center"></div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal" onclick="actualizar();">Cerrar</button>
			        <button type="button" class="nvt-btn nvt-btn-primary" id="btn-actualizarAreasTrabajo" onclick = "this.form.action = 'confirmarActualizacionAreas.php'">Actualizar</button>
			      </div>
			    </div>
		    </form>
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
		      	<!-- <video autoplay controls>
					<source src="../../gen/paso2.mp4" type="video/mp4"/>
				</video> -->
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="nvt-btn nvt-btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>



<script type = "text/javascript" src= "../../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type = "text/javascript" src= "../../js/jquery-ui.min.js"></script>
<script type = "text/javascript" src= "../../js/bootstrap.min.js"></script>
<script src = "../../js/alertify.js"></script>
<script type = "text/javascript" src= "../../js/jquery.funciones.js"></script>
<script src="js/AreasTrabajo.js"></script>
<script src="../../js/jquery.blockUI.js"></script>
<script src="../../js/jquery.dataTables.js"></script>
<script src="../../js/tables.js"></script>
<script src="../../js/jquery.validationEngine.js"></script>
<script src="../../js/languages/jquery.validationEngine-es.js"></script>
<script src="../../js/jquery.funciones.js"></script>
</body>
