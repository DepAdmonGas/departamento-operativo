<?php 
require('../../../app/help.php');

$sql = "SELECT * FROM op_rh_horario ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
?>

<table class="table table-sm table-bordered table-striped table-hover">
<thead>
<tr>
<th class=text-center align-middle>#</th>
<th class="align-middle">Titulo horario</th>
<th class="align-middle">Hora entrada</th>
<th class="align-middle">Hora salida</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar.png" /></th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
</thead>
</tr>

<tbody>
<?php
if($numero > 0){
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id = $row['id'];

echo '<tr>';
echo '<td class="text-center align-middle">'.$row['id'].'</td>';
echo '<td class="align-middle"><b>'.$row['titulo'].'</b></td>';
echo '<td class="align-middle">'.$row['hora_entrada'].'</td>';
echo '<td class="align-middle">'.$row['hora_salida'].'</td>';
echo '<td class="text-center align-middle"> <img src="'.RUTA_IMG_ICONOS.'editar.png" class="pointer" 
onclick="editarHorario('.$id.')"> </td>';
echo '<td class="text-center align-middle"> <img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer"
onclick="eliminarHorario('.$id.')"/> </td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}

?>
</tbody>
</table>


