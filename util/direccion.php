<?php
/* autor:       orlando puentes
 * fecha:       17/08/2010
 * objetivo:    <script type="text/javascript" src="../js/jquery.direccion.js"></script>
 */
?>
<html>

<script type="text/javascript" >
$(document).ready(function(){
	$(":input:first").focus();
	$("#uno").change(function(){
		$("#dos,#dos2").val('');
		if($(this).val()=='AVD'){
			$("#dos").hide();
			$("#dos2").show();
			}else{
			$("#dos").show();
			$("#dos2").hide();
			}
		});

	var arr = [];

	$('#div-direccion select,#div-direccion input:text').bind("blur",function(){

		var indice = parseInt($(this).attr('tabindex'))-1;

		arr[indice]=$(this).val();
		$('#tDirCompleta').val('');
	   $.each(arr,function(i,n){
		if(n!=undefined){
			     var esp = (i==9)?'-':' ';
			     $('#tDirCompleta').val($.trim($('#tDirCompleta').val()+esp+n.toUpperCase()));
		    }
		});
		//alert("Posicion "+indice+"= "+arr[indice]);
	});
});//fin ready
</script>
<style>
.requerido{ background:#E0FFC1; border:1px  solid  #55D92F}*/
</style>
<head>
<!-- <link href="../css/validationEngine.jquery.css" rel="stylesheet"> -->
</head>
<body >
<br/>
<span style="color:#390"><strong>(*)</strong></span><span>
Son Campos requeridos para ingresar la dirección</span><br>
<div style="vertical-align: top;margin-bottom:15px;">
<h4 style="width:100px;margin-right:0;display: inline-block;"> Dirección</h4>
				       <div class="row" style="width:500px;display:inline-block;vertical-align: top;">
							<div class="nvt-input-group dir-selector col-md-4" style="width:150px;">
								<select name="uno" class=" validate[required]" id="uno" tabindex="1">
									<option selected="selected" value=""></option>
									<option value="CALLE ">CALLE</option>
									<option value="CARRERA ">CARRERA</option>
									<option value="AVD">AVENIDA</option>
									<option value="TRASVERSAL ">TRASVERSAL</option>
									<option value="DIAGONAL ">DIAGONAL</option>
								</select>
							</div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:55px;">
								<input maxlength="3" size="10px" name="dos" id="dos" type="text" tabindex="2" class=" validate[required]">&nbsp;
							</div>
							<div class="nvt-input-group dir-selector col-md-2 hidden" >
								<input size="19" name="dos2" id="dos2" type="text" tabindex="2" class=" validate[required]" style="display:none;"/>
							</div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:55px;">
								<select name="tres" id="tres" tabindex="3">
									<option selected="selected" value="">&nbsp;</option>
									<option value="A ">A</option>
									<option value="B ">B</option>
									<option value="C ">C</option>
									<option value="D ">D</option>
									<option value="E ">E</option>
									<option value="F ">F</option>
									<option value="G ">G</option>
									<option value="H ">H</option>
									<option value="I ">I</option>
									<option value="J ">J</option>
									<option value="K ">K</option>
									<option value="L ">L</option>
									<option value="M ">M</option>
									<option value="N ">N</option>
									<option value="O ">O</option>
									<option value="P ">P</option>
									<option value="Q ">Q</option>
									<option value="R ">R</option>
									<option value="S ">S</option>
									<option value="T ">T</option>
									<option value="U ">U</option>
									<option value="V ">V</option>
									<option value="W ">W</option>
									<option value="X ">X</option>
									<option value="Y ">Y</option>
								<option value="Z ">Z</option>
								</select>
							</div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:90px;">
								<select name="cuatro" id="cuatro" tabindex="4">
									<option selected="selected" value="">&nbsp;</option>
									<option value="BIS ">BIS</option>
								</select>
							</div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:95px;">
								<select name="cinco" id="cinco" tabindex="5">
									<option selected="selected" value="">&nbsp;</option>
									<option value="W ">WEST</option>
									<option value="SUR ">SUR</option>
								</select>
							</div>
						</div>
						</div>
						<br>
						<div style="vertical-align: top;">
						<h4 style="width:100px;margin-right:0;display: inline-block;">Número</h4>
						<div class="row" style="width:500px;display:inline-block;vertical-align: top;">
						<div class="nvt-input-group dir-selector col-md-4" style="width:55px;">
						  <input name="seis" type="text" class="requerido" id="seis" tabindex="6" size="12" maxlength="3">&nbsp;
						</div>
						<div class="nvt-input-group dir-selector col-md-2" style="width:55px;">
						  <select name="siete" id="siete" tabindex="7">
							  <option selected="selected" value=""></option>
							  <option value="A ">A</option>
							  <option value="B ">B</option>
							  <option value="C ">C</option>
							  <option value="D ">D</option>
							  <option value="E ">E</option>
							  <option value="F ">F</option>
							  <option value="G ">G</option>
							  <option value="H ">H</option>
							  <option value="I ">I</option>
							  <option value="J ">J</option>
							  <option value="K ">K</option>
							  <option value="L ">L</option>
							  <option value="M ">M</option>
							  <option value="N ">N</option>
							  <option value="O ">O</option>
							  <option value="P ">P</option>
							  <option value="Q ">Q</option>
							  <option value="R ">R</option>
							  <option value="S ">S</option>
							  <option value="T ">T</option>
							  <option value="U ">U</option>
							  <option value="V ">V</option>
							  <option value="W ">W</option>
							  <option value="X ">X</option>
							  <option value="Y ">Y</option>
							  <option value="Z ">Z</option>
						  </select>
						  </div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:90px;">
							  <select name="ocho" id="ocho" tabindex="8">
								  <option selected="selected" value=""></option>
								  <option value="BIS ">BIS</option>
							  </select>
							</div>
							<div class="nvt-input-group dir-selector col-md-2" style="width:95px;">
							 <select name="nueve" id="nueve" tabindex="9">
								 <option selected="selected" value=""></option>
								 <option value="W ">WEST</option>
								 <option value="SUR ">SUR</option>
							 </select>
							</div>
							<div class="nvt-input-group dir-selector col-md-2">-
							 <input name="diez" type="text" class="requerido" id="diez" tabindex="10" size="12" maxlength="3" style="width:55px;">
							</div>
						</div>
					</div>
					</div>
						<br>
						<br>
<div class="row">
	<div class="col-md-12">Los siguientes campos no son obligatorios. Compl&eacute;telos solamente si es necesario.</div>
</div>
<br>
<div class="row">
	<div class="col-md-2">Datos Adicionales</div>
	<div class="col-md-3 nvt-input-group" style="width:130px;">
		<select name="once" id="once" tabindex="11">
			<option selected="selected" value="">&nbsp;</option>
			<option value="BARRIO ">BARRIO</option>
			<option value="OFICINA ">OFICINA</option>
			<option value="CONDOMINIO ">CONDOMINIO</option>
			<option value="EDIFICIO ">EDIFICIO</option>
			<option value="TORRE ">TORRE</option>
			<option value="MANZANA ">MANZANA</option>
			<option value="LOTE ">LOTE</option>
			<option value="CASA ">CASA</option>
			<option value="APTO ">APARTAMENTO</option>
			<option value="VEREDA ">VEREDA</option>
			<option value="FINCA ">FINCA</option>
			<option value="KM ">KILOMETRO</option>
			<option value="LOCAL ">LOCAL</option>
		</select>
	</div>
	<div class="col-md-3 nvt-input-group" style="width:130px;">
		<input maxlength="20" size="30" name="doce" id="doce" type="text" tabindex="12">
	</div>
</div>
<div class="row">
	<div class="col-md-2">Datos Adicionales</div>
	<div class="col-md-3 nvt-input-group" style="width:130px;">
		<select name="trece" id="trece" tabindex="13">
			<option selected="selected" value="">&nbsp;</option>
			<option value="BARRIO ">BARRIO</option>
			<option value="OFICINA ">OFICINA</option>
			<option value="CONDOMINIO ">CONDOMINIO</option>
			<option value="EDIFICIO ">EDIFICIO</option>
			<option value="TORRE ">TORRE</option>
			<option value="MANZANA ">MANZANA</option>
			<option value="LOTE ">LOTE</option>
			<option value="CASA ">CASA</option>
			<option value="APTO ">APARTAMENTO</option>
			<option value="VEREDA ">VEREDA</option>
			<option value="FINCA ">FINCA</option>
			<option value="KM ">KILOMETRO</option>
			<option value="LOCAL ">LOCAL</option>
		</select>
	</div>
<div class="col-md-3 nvt-input-group" style="width:130px;"><input maxlength="20" size="30" name="catorce" id="catorce" type="text" tabindex="14"></div>
</div>
<div class="row">
	<div class="col-md-2">Datos Adicionales</div>
	<div class="col-md-3 nvt-input-group" style="width:130px;">
		<select name="quince" id="quince" tabindex="15">
			<option selected="selected" value="">&nbsp;</option>
			<option value="BARRIO ">BARRIO</option>
			<option value="OFICINA ">OFICINA</option>
			<option value="CONDOMINIO ">CONDOMINIO</option>
			<option value="EDIFICIO ">EDIFICIO</option>
			<option value="TORRE ">TORRE</option>
			<option value="MANZANA ">MANZANA</option>
			<option value="LOTE ">LOTE</option>
			<option value="CASA ">CASA</option>
			<option value="APTO ">APARTAMENTO</option>
			<option value="VEREDA ">VEREDA</option>
			<option value="FINCA ">FINCA</option>
			<option value="KM ">KILOMETRO</option>
			<option value="LOCAL ">LOCAL</option>
		</select>
	</div>
<div class="col-md-3 nvt-input-group" style="width:130px;"><input maxlength="20" size="30" name="dieciseis" id="dieciseis" type="text" tabindex="16"></div>
</tr>
<br>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
<tbody>
<tr>
<td colspan="2" align="center"><input disabled="disabled" maxlength="256" size="70" name="tDirCompleta" id="tDirCompleta" type="text"></td>
</tr>
</tbody>
</table>
<!-- <script src="../js/jquery.validationEngine.js"></script>
<script src="../js/languages/jquery.validationEngine-es.js"></script> -->
</body>

<!--<body >
<br/>
<span style="color:#390"><strong>(*)</strong></span><span style="font-size:9px">
Son Campos requeridos para ingresar la dirección</span>
<table border="0" cellpadding="2" cellspacing="0" style="font-size: 10px">
<tr>
<td width="8%" class="ui-corner-tl">Dirección</td>
<td width="92%">
	<select name="uno" class="requerido" id="uno" tabindex="1" style="width: 100px">
	<option selected="selected" value="">Seleccione</option>
	<option value="CALLE ">CALLE</option>
	<option value="CARRERA ">CARRERA</option>
	<option value="AVD">AVENIDA</option>
	<option value="TRASVERSAL ">TRASVERSAL</option>
	<option value="DIAGONAL ">DIAGONAL</option>
	</select>

	<input maxlength="3" size="10px" name="dos" id="dos" type="text" tabindex="2" class="requerido">&nbsp;
	<input size="19" name="dos2" id="dos2" type="text" tabindex="2" class="requerido" style="display:none"/>

	<select name="tres" id="tres" tabindex="3" style="width:50px">
	<option selected="selected" value=""></option>
	<option value="A ">A</option>
	<option value="B ">B</option>
	<option value="C ">C</option>
	<option value="D ">D</option>
	<option value="E ">E</option>
	<option value="F ">F</option>
	<option value="G ">G</option>
	<option value="H ">H</option>
	<option value="I ">I</option>
	<option value="J ">J</option>
	<option value="K ">K</option>
	<option value="L ">L</option>
	<option value="M ">M</option>
	<option value="N ">N</option>
	<option value="O ">O</option>
	<option value="P ">P</option>
	<option value="Q ">Q</option>
	<option value="R ">R</option>
	<option value="S ">S</option>
	<option value="T ">T</option>
	<option value="U ">U</option>
	<option value="V ">V</option>
	<option value="W ">W</option>
	<option value="X ">X</option>
	<option value="Y ">Y</option>
	<option value="Z ">Z</option>
	</select>

	<select name="cuatro" id="cuatro" tabindex="4" style="width: 100px">
	<option selected="selected" value=""></option>
	<option value="BIS ">BIS</option>
	</select>

	<select name="cinco" id="cinco" tabindex="5" style="width: 100px">
	<option selected="selected" value=""></option>
	<option value="W ">WEST</option>
	<option value="SUR ">SUR</option>
</select>
</td>
</tr>
<tr>
<td width="11%" class="ui-corner-bl">N&uacute;mero&nbsp;&nbsp;</td>
<td><input name="seis" type="text" class="requerido" id="seis" tabindex="6" size="12" maxlength="3">&nbsp;
  <select name="siete" id="siete" tabindex="7" style="width:50px">
  <option selected="selected" value=""></option>
  <option value="A ">A</option>
  <option value="B ">B</option>
  <option value="C ">C</option>
  <option value="D ">D</option>
  <option value="E ">E</option>
  <option value="F ">F</option>
  <option value="G ">G</option>
  <option value="H ">H</option>
  <option value="I ">I</option>
  <option value="J ">J</option>
  <option value="K ">K</option>
  <option value="L ">L</option>
  <option value="M ">M</option>
  <option value="N ">N</option>
  <option value="O ">O</option>
  <option value="P ">P</option>
  <option value="Q ">Q</option>
  <option value="R ">R</option>
  <option value="S ">S</option>
  <option value="T ">T</option>
  <option value="U ">U</option>
  <option value="V ">V</option>
  <option value="W ">W</option>
  <option value="X ">X</option>
  <option value="Y ">Y</option>
  <option value="Z ">Z</option>
  </select>
  <select name="ocho" id="ocho" tabindex="8" style="width: 100px">
  <option selected="selected" value=""></option>
  <option value="BIS ">BIS</option>
  </select>
  -
 <select name="nueve" id="nueve" tabindex="9" style="width: 100px">
 <option selected="selected" value=""></option>
<option value="W ">WEST</option>
 <option value="SUR ">SUR</option>
 </select>
 <input name="diez" type="text" class="requerido" id="diez" tabindex="10" size="12" maxlength="3"></td>
</tr>
</tbody>
</table>
<br>
<div style="font-size:10px;color:#F00">
Los siguientes campos no son obligatorios. Compl&eacute;telos solamente si es necesario.
</div>
<br>
<table width="60%" border="0" cellpadding="3" cellspacing="0" style="font-size: 10px">
<tbody>
<tr>
<td width="22%" bgcolor="#EBEBEB" >Datos Adicionales</td>
<td width="32%" bgcolor="#EBEBEB">
<select name="once" id="once" tabindex="11">
<option selected="selected" value=""></option>
<option value="BARRIO ">BARRIO</option>
<option value="OFICINA ">OFICINA</option>
<option value="CONDOMINIO ">CONDOMINIO</option>
<option value="EDIFICIO ">EDIFICIO</option>
<option value="TORRE ">TORRE</option>
<option value="MANZANA ">MANZANA</option>
<option value="LOTE ">LOTE</option>
<option value="CASA ">CASA</option>
<option value="APTO ">APARTAMENTO</option>
<option value="VEREDA ">VEREDA</option>
<option value="FINCA ">FINCA</option>
<option value="KM ">KILOMETRO</option>
<option value="LOCAL ">LOCAL</option>
</select></td>
<td width="46%"  bgcolor="#EBEBEB" >
<input maxlength="20" size="30" name="doce" id="doce" type="text" tabindex="12"></td>
</tr>
<tr>
<td bgcolor="#EBEBEB">Datos Adicionales</td>
<td bgcolor="#EBEBEB">
<select name="trece" id="trece" tabindex="13">
<option selected="selected" value=""></option>
<option value="BARRIO ">BARRIO</option>
<option value="OFICINA ">OFICINA</option>
<option value="CONDOMINIO ">CONDOMINIO</option>
<option value="EDIFICIO ">EDIFICIO</option>
<option value="TORRE ">TORRE</option>
<option value="MANZANA ">MANZANA</option>
<option value="LOTE ">LOTE</option>
<option value="CASA ">CASA</option>
<option value="APTO ">APARTAMENTO</option>
<option value="VEREDA ">VEREDA</option>
<option value="FINCA ">FINCA</option>
<option value="KM ">KILOMETRO</option>
<option value="LOCAL ">LOCAL</option>
</select></td>
<td bgcolor="#EBEBEB"><input maxlength="20" size="30" name="catorce" id="catorce" type="text" tabindex="14"></td>
</tr>
<tr>
<td bgcolor="#EBEBEB">Datos Adicionales</td>
<td bgcolor="#EBEBEB"><select name="quince" id="quince" tabindex="15">
<option selected="selected" value=""></option>
<option value="BARRIO ">BARRIO</option>
<option value="OFICINA ">OFICINA</option>
<option value="CONDOMINIO ">CONDOMINIO</option>
<option value="EDIFICIO ">EDIFICIO</option>
<option value="TORRE ">TORRE</option>
<option value="MANZANA ">MANZANA</option>
<option value="LOTE ">LOTE</option>
<option value="CASA ">CASA</option>
<option value="APTO ">APARTAMENTO</option>
<option value="VEREDA ">VEREDA</option>
<option value="FINCA ">FINCA</option>
<option value="KM ">KILOMETRO</option>
<option value="LOCAL ">LOCAL</option>
</select></td>
<td bgcolor="#EBEBEB" ><input maxlength="20" size="30" name="dieciseis" id="dieciseis" type="text" tabindex="16"></td>
</tr>
</tbody>
</table>
<br>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
<tbody>
<tr>
<td colspan="2" align="center"><input disabled="disabled" maxlength="256" size="70" name="tDirCompleta" id="tDirCompleta" type="text"></td>
</tr>
</tbody>
</table>
</body>
</html>-->
