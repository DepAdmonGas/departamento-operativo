<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_inventario_pinturas WHERE id_estacion = '".$Session_IDEstacion."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$Session_IDEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT unidad, producto FROM op_pinturas_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$unidad = $row_listaestacion['unidad'];
$producto = $row_listaestacion['producto'];
}
$result = array('unidad' => $unidad, 'producto' => $producto);

return $result;
}
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold">#</th>
  <th class="text-center align-middle font-weight-bold">Unidad</th>
  <th class="text-center align-middle font-weight-bold">Producto</th>
  <th class="text-center align-middle font-weight-bold">Piezas</th>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$Producto = Producto($row_lista['id_producto'], $con);


echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center"><b>'.$Producto['unidad'].'</b></td>';
echo '<td class="align-middle text-center"><b>'.$Producto['producto'].'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
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