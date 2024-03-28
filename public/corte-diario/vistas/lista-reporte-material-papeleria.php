<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT producto FROM op_papeleria_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$producto = $row_listaestacion['producto'];
}
$result = array('producto' => $producto);

return $result;
}

$sql_reporte = "SELECT * FROM op_papeleria_reporte WHERE id = '".$idReporte."' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
$fecha = $row_reporte['fecha']; 
$hora = $row_reporte['hora']; 
$detalle = $row_reporte['detalle'];
$status = $row_reporte['status'];
}
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .8em;">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Producto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Piezas</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Observación</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead>

<tbody>
<?php
$sql_detalle = "SELECT * FROM op_papeleria_reporte_detalle WHERE id_reporte = '".$idReporte."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);
if ($numero_detalle > 0) {

while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$id = $row_detalle['id'];
$idProducto = $row_detalle['id_producto'];
$NomProducto = Producto($idProducto, $con);
$unidad = $row_detalle['unidad'];
echo '<tr>';
echo '<td class="align-middle text-center">'.$id.'</td>';
echo '<td class="align-middle text-center">'.$NomProducto['producto'].'</td>';
echo '<td class="align-middle text-center">'.$unidad.'</td>';
echo '<td class="align-middle text-center">'.$row_detalle['observaciones'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItemReporte('.$idReporte.', '.$id.', '.$idProducto.')"></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

<?php 
if($numero_detalle > 0){
echo '<hr>';
echo '<div class="text-end">
        <button type="button" class="btn btn-success" onclick="FinalizarReporte('.$idReporte.')">Finalizar Reporte</button>
</div>';
}
?>