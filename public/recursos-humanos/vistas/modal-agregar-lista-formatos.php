<?php
require('../../../app/help.php');

?>
<div class="modal-header">

<h5 class="modal-title">Agregar Formato</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<h6 class="mb-1">* Clave del formato:</h6>
<textarea class="form-control" id="Clave"></textarea>

<h6 class="mb-1 mt-3">* Nombre Formato:</h6>
<textarea class="form-control" id="Formato"></textarea>

<h6 class="mb-1 mt-3">* Archivo</h6>
<input class="form-control" type="file" id="seleccionArchivos">

<div id="Mensaje mt-2"></div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(0)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
 