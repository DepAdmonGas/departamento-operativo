<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

?>
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="mb-2"><small class="text-secondary">Año:</small></div>
<input class="form-control" type="number" class="mt-1" id="Year" placeholder="Ingresa aqui la fecha...">
</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Buscar(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>
</div>
 