<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
<h5 class="modal-title">Entregables del trabajo realizado</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <h6 class="mb-1">Archivo:</h6>
  <input class="form-control" type="file" id="Archivo">

  <h6 class="mt-2 mb-1">Detalle:</h6>
  <select class="form-select" id="Detalle">
    <option></option>
    <option>Antes</option>
    <option>Despues</option>
  </select>

  <div class="mt-2" id="result"></div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="GuardarArhivo(<?=$idReporte?>)">Guardar</button>
</div>
</div>
