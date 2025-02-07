<?php
require('../../../../../app/help.php');
?>
<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
<label class="text-secondary fw-bold">* FECHA DE INICIO:</label>
<input type="date" class="form-control rounded-0 mt-1" id="fecha_inicio">

<label class="text-secondary fw-bold mt-3">* FECHA DE FIN:</label>
<input type="date" class="form-control rounded-0 mt-1" id="fecha_fin">

</div>


<div class="modal-footer">

<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>

<button type="button" class="btn btn-labeled2 btn-success" onclick="Buscar()">
<span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>

</div>