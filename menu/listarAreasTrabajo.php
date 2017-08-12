<?php 

include_once("../src/DBManejador.php");
$manejador = new DBManejador();

$tabla="pruebas";
$columnas = "nombre,apellido,direccion";

$resultado =  $manejador->consultar($columnas,$tabla,$getObjects = false);

if($resultado > 0 )
echo "Grabo";
else 
echo "Error";
?>

<table>
    <thead>
         <th>
        Nombre
        </th>
         <th>
        Apellido
        </th>
         <th>
        Direccion
        </th>
         <th>
        Accion
        </th>
    </thead>
    <tbody>
           <?php while ($row = mysql_fetch_array($resultado) ): ?>
                <tr>
                <td><?php echo $row["nombre"]; ?></td>
                <td><?php echo $row["apellido"]; ?></td>
                <td><?php echo $row["direccion"]; ?></td>
                <td>
                <a href="editarAreasTrabajo.php?id=<?php echo $row["id_persona"]; ?>">Editar</a></td>
                <a href="eliminarAreasTrabajo.php?id=<?php echo $row["id_persona"]; ?>">Eliminar</a></td>
                
                </tr>
                <?php endwhile;?>
           
          
    </tbody>
</table>