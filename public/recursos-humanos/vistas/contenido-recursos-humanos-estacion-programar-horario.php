<?php 
require('../../../app/help.php');

$idEstacion = $Session_IDEstacion;

$sql_empresa = "SELECT * FROM op_rh_personal_horario_programar WHERE id_estacion = '".$idEstacion."' AND estado >= 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
?>
 
<div class="table-responsive">
<table class="table table-sm table-bordered table-striped table-hover mb-0">
<thead class="tables-bg">
<tr>
<th class=text-center align-middle>#</th>
<th class="align-middle">Fecha programada</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
</thead>
</tr>

<tbody>
<?php
if($numero_empresa > 0){
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$id = $row_empresa['id'];

if($row_empresa['estado'] == 1){
$trcolor = "table-warning";
$eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer" onclick="Eliminar('.$id.')"/>';
}else if($row_empresa['estado'] == 2){
$trcolor = "table-success";	
$eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer"/>';
}

echo '<tr class="'.$trcolor.' pointer">';
echo '<td class="text-center align-middle" onclick="Detalle('.$id.')">'.$row_empresa['id'].'</td>';
echo '<td class="align-middle" onclick="Detalle('.$id.')">'.FormatoFecha($row_empresa['fecha']).'</td>';
echo '<td class="text-center align-middle">'.$eliminar.'</td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}

?>
</tbody>
</table>
</div>