<?php 
require('../../../app/help.php');

$sql_empresa = "SELECT * FROM op_rh_puestos WHERE status = 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-striped table-hover mb-0">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle" width="64px">#</th>
<th class="align-middle">Puesto</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" /></th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
</thead>
</tr>

<tbody>
<?php
if($numero_empresa > 0){
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$id = $row_empresa['id'];

echo '<tr>';
echo '<td class="text-center align-middle">'.$row_empresa['id'].'</td>';
echo '<td class="align-middle">'.$row_empresa['puesto'].'</td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer" 
onclick="editarPuesto('.$id.')"> </td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer"
onclick="eliminarPuesto('.$id.')"/> </td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}
 
?>
</tbody>
</table>
</thead>

