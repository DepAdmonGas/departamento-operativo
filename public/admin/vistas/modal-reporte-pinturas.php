<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

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

$sql_reporte = "SELECT * FROM op_pinturas_complementos_reporte WHERE id = '".$idReporte."' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
$fecha = $row_reporte['fecha']; 
$hora = $row_reporte['hora']; 
$detalle = $row_reporte['detalle'];
$status = $row_reporte['status'];
}
?>
<script type="text/javascript">
$('.selectize').selectize({
sortField: 'text'
});
</script>
<div class="modal-header">
<h5 class="modal-title">Agregar reporte de pinturas</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

        <div class="row mt-2">
        <div class="col-6">
        <div class="mb-2 text-secondary">Fecha:</div>
        <input type="date" class="form-control rounded-0" id="Fecha" value="<?=$fecha;?>">
        </div>
        <div class="col-6">
        <div class="mb-2 text-secondary">Hora:</div>
        <input type="time" class="form-control rounded-0" id="Hora" value="<?=$hora;?>">
        </div>
        <div class="col-12">
        <div class="mb-2 text-secondary">Detalle:</div>
        <textarea class="form-control rounded-0" id="Detalle"><?=$detalle;?></textarea>
        </div>
        </div>

  <div class="text-right mt-3">
  <button type="button" class="btn btn-primary btn-sm" onclick="GuardarReporte(<?=$idEstacion;?>,<?=$idReporte;?>)">Guardar</button>
  </div>

<?php  if($status == 1){ ?>
        <hr>

        <h6>Material utilizado</h6>

        <div class="row mt-2">

        <div class="col-7">
        <div class="mb-2 text-secondary">Pintura o complemento:</div>
        <select class="selectize" placeholder="Producto" id="Producto">
        <option value="">Selecciona</option>
        <?php 
        $sql_lista = "SELECT * FROM op_inventario_pinturas WHERE id_estacion = '".$idEstacion."' AND piezas > 0 AND status = 1 ORDER BY id ASC";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);
        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

        $Producto = Producto($row_lista['id_producto'],$con);
        echo '<option value="'.$row_lista['id_producto'].'">'.$Producto['producto'].'</option>';
        }
        ?>
        </select>  
        </div>

        <div class="col-3">
        <div class="mb-2 text-secondary">Piezas utilizadas:</div>
        <input type="number" class="form-control rounded-0" id="Unidad">
        </div>

        <div class="col-2">
        <div class="mb-2 text-secondary" style="padding-bottom: 25px;"></div>
        <button type="button" class="btn btn-success btn-sm" onclick="AgregarItemReporte(<?=$idEstacion;?>,<?=$idReporte;?>)">Agregar</button>
        </div>

        </div> 

        <hr> 

<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold">#</td>
   <td class="text-center align-middle tableStyle font-weight-bold">Unidad</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Producto</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Piezas</td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
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
echo '<td class="align-middle text-center">'.$id.'</td>';
echo '<td class="align-middle text-center">'.$NomProducto['unidad'].'</td>';
echo '<td class="align-middle text-center">'.$NomProducto['producto'].'</td>';
echo '<td class="align-middle text-center">'.$unidad.'</td>';
echo '<td class="align-middle text-center"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItemReporte('.$idEstacion.','.$idReporte.', '.$id.', '.$idProducto.')"></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>

<?php 
if($numero_detalle > 0 && $status == 1){
echo '<hr>';
echo '<div class="text-right">
        <button type="button" class="btn btn-success" onclick="FinalizarReporte('.$idEstacion.','.$idReporte.')">Finalizar Reporte</button>
</div>';
}
?>

<?php  } ?>



</div>

