<?php
require('../../../app/help.php');

$idEvidencia = $_GET['idEvidencia'];
?>
<div class="modal-header">
  <h5 class="modal-title">Agregar imagen</h5>
</div>
<div class="modal-body">

<label class="text-secondary mb-1">Imagen:</label>
<div><input type="file" class="form-control" id="Imagen"></div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary rounded-0" onclick="AgregarEvidenciaImagen(<?=$idEvidencia;?>)">Agregar</button>
</div>
  