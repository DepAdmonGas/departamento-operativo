<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
  <h5 class="modal-title">Agregar Refacturación</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary fw-bold">* ESTACIÓN:</div>
  <select class="form-select" id="Estacion">
    <option></option>
    <?php
    $sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);
    while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
      $estacion = $row_listaestacion['localidad'];

      echo '<option value="' . $row_listaestacion['id'] . '">' . $estacion . '</option>';
    }
    ?>
  </select>

  <div class="mb-1 mt-2 text-secondary fw-bold">* DESCRIPCIÓN:</div>
  <textarea class="form-control" id="Descripcion"></textarea>

  <div class="mb-1 mt-2 text-secondary fw-bold">* CANTIDAD:</div>
  <input type="number" class="form-control" id="Cantidad">

  <div class="mb-1 mt-2 text-secondary fw-bold">* IMPORTE:</div>
  <input type="number" class="form-control" id="Importe">

  <div class="mb-1 mt-2 text-secondary fw-bold">PORCENTAJE:</div>
  <input type="number" class="form-control" id="Porcentaje">

  <div class="mb-1 mt-2 text-secondary fw-bold">ESTACION:</div>
  <input type="number" class="form-control" id="CantidadES">

  <div class="mb-1 mt-2 text-secondary fw-bold">ALMACÉN:</div>
  <input type="number" class="form-control" id="CantidadAl">

</div>
<div class="modal-footer">

  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="AgregarRefacturacion(<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>