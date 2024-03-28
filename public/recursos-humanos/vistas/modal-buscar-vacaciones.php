<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

?>
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Año:</small></div>
<input class="form-control" type="number" class="mt-1" id="Year">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Buscar(<?=$idEstacion;?>)">Buscar</button>
</div>
 