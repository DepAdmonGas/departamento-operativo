<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>

<div class="modal-header">
  <h5 class="modal-title">Agregar factura</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="mb-1 text-secondary fw-bold">* AÑO:</div>
  <input type="number" class="form-control" id="Year">

  <div class="mb-1 mt-2 text-secondary fw-bold">* PERIODO:</div>
  <select class="form-select" id="Periodo">
    <option value="">Selecciona una opción...</option>
    <option value="Primer periodo">Primer periodo</option>
    <option value="Segundo periodo">Segundo periodo</option>
  </select>

  <div class="mb-1 text-secondary mt-2 fw-bold">* Archivo:</div>
  <input class="form-control" type="file" id="Archivo">

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?= $idEstacion ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>