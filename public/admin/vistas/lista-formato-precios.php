<?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_formato_precios WHERE YEAR(fecha) = '".$year."' AND MONTH(fecha) = '".$mes."' AND estatus = 1 ORDER BY fecha DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead>
  <th class="text-center align-middle font-weight-bold bg-light">#</th>
  <th class="align-middle font-weight-bold bg-light">Fecha</th>
  <th class="text-center align-middle text-center bg-light" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar.png"></th>
  <th class="text-center align-middle text-center bg-light" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];


echo '<tr>';
echo '<td class="align-middle text-center" onclick="Detalle('.$id.')">'.$num.'</td>';
echo '<td class="align-middle" onclick="Detalle('.$id.')">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center"><img src="'.RUTA_IMG_ICONOS.'editar.png" onclick="Editar('.$id.','.$year.','.$mes.')"></td>';
echo '<td class="align-middle text-center"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Cancelar('.$id.','.$year.','.$mes.')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>   
</div>