<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
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

$sql_lista = "SELECT * FROM op_pinturas_complementos_reporte WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$personal = Personal($row_lista['id_usuario'],$con);
$fecha = FormatoFecha($row_lista['fecha']);
$hora = date('g:i a', strtotime($row_lista['hora']));

$nomRefaccion = $Refaccion['nombre'];
$imagen = $Refaccion['imagen'];

$unidad = $row_lista['unidad'];
$detalle = $row_lista['detalle'];
}

?>
<div class="modal-header">
<h5 class="modal-title">Detalle del reporte</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
    <h6 class="text-secondary ">Personal:</h6>
    <?=$personal;?>
  </div>

  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
    <h6 class="text-secondary ">Fecha:</h6>
    <?=$fecha;?>
  </div>
  
  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-2">
    <h6 class="text-secondary ">Hora:</h6>
    <?=$hora;?>
  </div>

</div>


<div class="row">
  <div class="col-12">
      <h6 class="mb-1 text-secondary">Detalle:</h6>
    <div class=""><?=$detalle;?></div>
  </div>
</div>

<h6 class="mb-1 text-secondary">Pinturas y complementos</h6>
<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold">Unidad</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Producto</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Piezas</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Observación</td>
  </tr>
</thead> 
<tbody>
<?php
$sql_detalle = "SELECT * FROM op_pinturas_complementos_reporte_detalle WHERE id_reporte = '".$idReporte."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);
if ($numero_detalle > 0) {

while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$id = $row_detalle['id'];
$idProducto = $row_detalle['id_producto'];
$NomProducto = Producto($idProducto, $con);
$unidad = $row_detalle['unidad'];
echo '<tr>';
echo '<td class="align-middle text-center">'.$NomProducto['unidad'].'</td>';
echo '<td class="align-middle text-center">'.$NomProducto['producto'].'</td>';
echo '<td class="align-middle text-center">'.$unidad.'</td>';
echo '<td class="align-middle text-center">'.$row_detalle['observaciones'].'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>

</div>
