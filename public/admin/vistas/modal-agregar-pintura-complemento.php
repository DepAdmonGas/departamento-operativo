<?php
require ('../../../app/help.php');

$idProducto = $_GET['idProducto'];

if ($idProducto == 0) {
  $producto = "";
  $unidad = "Seleccione";
  $value = "";
} else {

  $sql_producto = "SELECT * FROM op_pinturas_lista WHERE id = '" . $idProducto . "' ";
  $result_producto = mysqli_query($con, $sql_producto);
  $numero_producto = mysqli_num_rows($result_producto);
  while ($row_producto = mysqli_fetch_array($result_producto, MYSQLI_ASSOC)) {

    $producto = $row_producto['producto'];
    $unidad = $row_producto['unidad'];
    $value = $row_producto['unidad'];
  }
}
?>

<div class="modal-header">
  <h5 class="modal-title">Agregar pintura y complemento</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="mb-1 text-secondary fw-bold">* PRODUCTO:</div>
  <textarea class="form-control rounded-0" id="Producto"><?= $producto; ?></textarea>

  <div class="mb-1 mt-2 text-secondary fw-bold">* UNIDAD:</div>
  <select class="form-select rounded-0" id="Unidad">
    <option value="<?= $value; ?>"><?= $unidad; ?></option>

    <option value="CUB.">CUB.</option>
    <option value="KILO.">KILO.</option>
    <option value="LT.">LT.</option>
    <option value="PZA.">PZA.</option>
  </select>

</div>
<div class="modal-footer">

  <button type="button" class="btn btn-labeled2 btn-success" onclick="CreateUpdateProducto(<?= $idProducto; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>