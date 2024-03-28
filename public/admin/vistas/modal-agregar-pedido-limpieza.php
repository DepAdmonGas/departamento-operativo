<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_productos = "SELECT * FROM op_limpieza_lista ORDER BY producto ASC";
$result_productos = mysqli_query($con, $sql_productos);
$numero_productos = mysqli_num_rows($result_productos);

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT unidad, producto FROM op_limpieza_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$unidad = $row_listaestacion['unidad'];
$producto = $row_listaestacion['producto'];
}
$result = array('unidad' => $unidad, 'producto' => $producto);

return $result;
}

function TotalPedido($IDEstacion, $estatus, $con){
$sql = "SELECT status FROM op_pedido_limpieza WHERE id_estacion = '".$IDEstacion."' AND status = '".$estatus."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
return $numero;
}

$TotalPedido1 = TotalPedido($idEstacion,1, $con);
?>
<div class="modal-header">
<h5 class="modal-title">Agregar pedido limpieza</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">

        <div class="row">
        <div class="col-10">
        <div class="mb-1 text-secondary">Producto:</div>
        <select class="form-select rounded-0" id="Producto">
          <option value="">Selecciona</option>
          <?php

          while($row_productos = mysqli_fetch_array($result_productos, MYSQLI_ASSOC)){

          echo '<option value="'.$row_productos['id'].'">'.$row_productos['producto'].'</option>';  
          }

          ?>
        </select>
          </div>

          <div class="col-2">
        <div class="mb-0 mt-1 text-secondary">Piezas:</div>
        <input type="number" min="0" class="form-control rounded-0" id="Piezas">
          </div>

        </div>

      <div class="text-end mt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="AgregarItem(<?=$idEstacion;?>,<?=$idReporte;?>)">Agregar</button>
      </div>

      <hr>

<div class="table-responsive">
      <table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
       <thead class="tables-bg">
      <tr>
      <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
      <td class="align-middle tableStyle font-weight-bold"><b>Unidad</b></td>
      <td class="align-middle tableStyle font-weight-bold"><b>Producto</b></td>
      <td class="align-middle tableStyle font-weight-bold text-center"><b>Piezas</b></td>
      <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
      </tr>
    </thead>  
    <tbody>
    <?php
    $sql_lista = "SELECT * FROM op_pedido_limpieza_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    $Producto = Producto($row_lista['id_producto'], $con);

    $ToPiezas = $ToPiezas + $row_lista['piezas'];

    echo '<tr>';
    echo '<td class="align-middle text-center">'.$num.'</td>';
    echo '<td class="align-middle"><b>'.$Producto['unidad'].'</b></td>';
    echo '<td class="align-middle"><b>'.$Producto['producto'].'</b></td>';
    echo '<td class="align-middle p-0 text-center"><input id="Piezas-'.$id.'" class="form-control border-0 text-center" type="number" value="'.$row_lista['piezas'].'" onchange="EditPiezas('.$id.','.$idEstacion.','.$idReporte.')" /></td>';
    
    echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItem('.$id.','.$idEstacion.','.$idReporte.')"></td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="3" class="text-end">Total piezas:</td>
    <td class="text-center"><b>'.$ToPiezas.'</b></td>
    <td class="text-center"></td>
    </tr>';

    }else{
    echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>


      </div>

