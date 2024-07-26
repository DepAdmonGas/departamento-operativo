<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion']; 

?>
 
<div class="modal-header">
<h5 class="modal-title">Agregar Rol de Comodines</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-secondary"><small>El rol debe ser subido en imagen .PNG o .JPG</small></div>

<h6 class="mb-1 mt-2">* Rol de Comodines</h6>
<input class="form-control" type="file" id="seleccionArchivos">

<h6 class="mt-3 mb-1">Comentario</h6>
<textarea class="form-control" id="Observaciones"></textarea>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Cerrar</button>

<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarRol(<?=$idEstacion?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>

</div> 