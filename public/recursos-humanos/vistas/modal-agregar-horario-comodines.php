<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion']; 

?>
 
<div class="modal-header">
<h5 class="modal-title">Agregar Rol de Comodines</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-secondary"><small>El rol debe ser subido en imagen .PNG o .JPG</small></div>

<h6 class="mb-1 mt-2">* Rol de Comodines</h6>
<input class="form-control" type="file" id="seleccionArchivos">

<h6 class="mt-2 mb-1">Comentario</h6>
<textarea class="form-control" id="Observaciones"></textarea>

<div id="Mensaje mt-2"></div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
<button type="button" class="btn btn-primary" onclick="AgregarRol(<?=$idEstacion?>)">Agregar</button>
</div> 