<?php
/*
 * @autor: Juan Diego  Ninco Collazos
 * @fecha: 2017-27-07
 * @objetivo: Mostrar lista de usuarios
 */
@session_start();
date_default_timezone_set('America/Bogota');
ini_set("display_errors", '1');
include_once '../../rsc/DBManejador.php';
include_once '../../rsc/session.php';
$conn = new DBManejador();
if ($conn == null) {
    echo -1;
    exit();
}

if (!session::existsAttribute("LOGEADO")) {
    header("location: ../../index.php");
}

$id_empresa = $_SESSION['IDEMPRESA'];

$columnas = "p.*, e.*, a.*, c.*, p.fecha_sistema AS fecha_persona";
$tabla    = "gen_personas AS p INNER JOIN ges_empleados AS e ON e.id_persona=p.id_persona INNER JOIN gen_areas_trabajo AS a "
    . "ON e.id_area_trabajo=a.id_area_trabajo INNER JOIN gen_cargos AS c ON e.id_cargo=c.id_cargo";
$condicion = "e.id_empresa = :v1 AND e.fecha_eliminado IS NULL ORDER BY p.primer_nombre";
$valores   = array(":v1" => $id_empresa);

$rs_consultar = $conn->consultarCondicion($columnas, $tabla, $condicion, $valores);

$contador = 0;

?>

<?php
foreach ($rs_consultar as $row) {
    $contador++;
    ?>

<tr>
    <td><div class="checkbox-input"><label for="checkbox"><label for="checkbox"><input type="checkbox" name="usuarios[]" id="<?php echo $row['id_persona'] ?>"><?php echo $contador ?></label></div></td>
    <td><img style="height: 50px; width: 50px" src="<?php echo $row['url_foto'] ?>"></td>
    <td><?php echo $row['numero_documento'] ?></td>
    <td><?php echo $row['primer_nombre'] . ' ' . $row['segundo_nombre'] ?></td>
    <td><?php echo $row['primer_apellido'] . ' ' . $row['segundo_apellido'] ?></td>
    <td><?php echo $row['fecha_persona'] ?></td>
    <td><?php echo $row['cargo'] ?></td>
    <td><?php echo $row['area_trabajo'] ?></td>
    <td>
    <?php
if ($row['estado_empleado'] == 1) {
        echo "Activo";
    } else {
        echo "Inactivo";
    }
    ?></td>

</tr>


<?php }?>