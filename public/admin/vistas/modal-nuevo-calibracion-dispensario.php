<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>

      <div class="modal-header">
        <h5 class="modal-title">Agregar factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <div class="mb-1 text-secondary">Año:</div>
        <input type="number" class="form-control" id="Year">

        <div class="mb-1 mt-2 text-secondary">Periodo:</div>
        <select class="form-select" id="Periodo">
          <option value="">Selecciona</option>
          <option value="Primer periodo">Primer periodo</option>
          <option value="Segundo periodo">Segundo periodo</option>
        </select>
        
        <div class="mb-1 text-secondary mt-2">Archivo:</div>
        <input class="form-control" type="file" id="Archivo">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
      </div>