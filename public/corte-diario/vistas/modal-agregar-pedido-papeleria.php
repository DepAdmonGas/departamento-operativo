<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_papeleria_lista ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT producto FROM op_papeleria_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$producto = $row_listaestacion['producto'];
}
$result = array('producto' => $producto);

return $result;
}
?>
<script type="text/javascript">
$('.selectize').selectize({
sortField: 'text'
});
</script>


<div class="modal-header">
<h5 class="modal-title">Crear pedido de papelería</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


    <div class="modal-body">

      <div class="mb-1 text-secondary">Producto:</div>
        <select class="selectize pointer" placeholder="Producto" id="Producto">
          <option value="">Producto</option>
        <?php
        while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
          echo '<option value="'.$row_lista['producto'].'">'.$row_lista['producto'].'<option>';
        }

        ?>
        </select> 

        <div class="mb-1 text-secondary mt-2">Otro Producto:</div>
        <input type="text" class="form-control rounded-0" id="OtroProducto">

        <div class="mb-1 mt-2 text-secondary">Piezas:</div>
        <input type="number" class="form-control rounded-0" id="Piezas">

        <hr>
  
       <div class="text-end mb-3"><button type="button" class="btn btn-primary btn-sm" onclick="AgregarItem(<?=$idReporte;?>)">Agregar producto</button></div>

 

    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
       <thead class="tables-bg">
      <tr>
      <th class="text-center align-middle tableStyle font-weight-bold">#</th>
      <th class="text-center align-middle tableStyle font-weight-bold">Producto</th>
      <th class="align-middle tableStyle font-weight-bold text-center">Piezas</th>
      <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
      </tr>
    </thead>  
    
    <tbody>
    <?php
    $sql_lista = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    $Producto = $row_lista['producto'];

    $ToPiezas = $ToPiezas + $row_lista['piezas'];

    echo '<tr>';
    echo '<td class="align-middle text-center">'.$num.'</td>';
    echo '<td class="align-middle text-center"><b>'.$Producto.'</b></td>';
    echo '<td class="align-middle p-0 text-center"><input id="Piezas-'.$id.'" class="form-control border-0 text-center" type="number" value="'.$row_lista['piezas'].'" onchange="EditPiezas('.$id.','.$idReporte.')" /></td>';
    
    echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItem('.$id.','.$idReporte.')"></td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="2" class="text-end">Total piezas:</td>
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

    </div>
    

    <?php if ($numero_lista > 0) { ?>
    <div class="modal-footer">
    <button type="button" class="btn btn-success" onclick="FinalizarPedido(<?=$idReporte;?>)">Finalizar pedido</button>
    </div>
    <?php } ?>


