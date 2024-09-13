<?php
require('../../../app/help.php');

$idPedido = $_GET['idPedido'];

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$comentarios = $row_pedido['comentarios'];
}

$sql_lista = "SELECT * FROM op_refacciones WHERE id_estacion = '".$id_estacion."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<div class="modal-header">
<h5 class="modal-title">Refacciones</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
 
  <label class="text-secondary fw-bold">* REFACCIÓN</label>
  <select class=" form-select" placeholder="Refacciones" id="Concepto">
  <option value=""></option>
  <?php
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  echo '<option value="'.$row_lista['id'].'">'.$row_lista['nombre'].' ('.$row_lista['estado_r'].')</option>';
  }
  ?>
  </select>

<label class="text-secondary fw-bold">OTRO</label>
<input type="text" class="form-control rounded-0" id="Otro">

<label class="text-secondary mt-2 fw-bold">* CANTIDAD</label>
<input type="text" class="form-control rounded-0" id="Cantidad">

</div>
<div class="modal-footer">

  <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
         <span class="btn-label2"><i class="fa-regular fa-circle-xmark"></i></span>Cancelar</button>

  <button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarMaterial(<?=$idPedido;?>)">
    <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>



</div> 