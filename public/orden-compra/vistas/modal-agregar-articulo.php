<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
  <h5 class="modal-title">Agregar articulo</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary">Proveedor:</div>
  <select class="form-select" id="Proveedor">
    <option></option>
    <?php
    $sql = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '" . $idReporte . "' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

      $id = $row['id'];

      echo '<option value="' . $id . '">' . $row['razon_social'] . '</option>';
    }
    ?>
  </select>

  <div class="mb-1 mt-2 text-secondary">Concepto:</div>
  <textarea class="form-control" id="Concepto"></textarea>

  <div class="mb-1 mt-2 text-secondary">Unidades:</div>
  <input type="number" class="form-control" id="Unidades">


  <div class="mb-1 mt-2 text-secondary">Estatus:</div>
  <select class="form-select" id="EstatusR">
    <option></option>
    <option value="Nuevo">Nuevo</option>
    <option value="Usado">Usado</option>

  </select>

  <div class="mb-1 mt-2 text-secondary">Precio Unitario:</div>
  <input type="number" class="form-control" id="PrecioUnitario">


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="AgregarArticulo(<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>