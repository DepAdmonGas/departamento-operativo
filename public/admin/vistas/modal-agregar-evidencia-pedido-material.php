<?php
require('../../../app/help.php');

$idPedido = $_GET['idPedido'];
?>
<div class="modal-header">
  <h5 class="modal-title">Evidencia</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<label class="text-secondary mb-1">Selecciona el archivo:</label>
<input class="form-control" type="file" id="archivoEvidencia">

 
<div class="row ">
<div class="col-6">
  <label class="text-secondary mb-1 mt-2">* Area</label>
  <textarea class="form-control" id="Area"></textarea>
</div>
<div class="col-6">
  <label class="text-secondary mb-1 mt-2">* Motivo</label>
  <textarea class="form-control" id="Motivo"></textarea>
</div>
</div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary rounded-0" onclick="AgregarEvidencia(<?=$idPedido;?>)">Agregar</button>
</div>
  