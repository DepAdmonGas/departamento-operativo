<?php
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?> 

<div class="modal-header">
<h5 class="modal-title">Buscar Reporte</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-1">
<div class="fw-bold text-secondary">* FECHA INICIO:</div>
<input type="date" class="form-control rounded-0" id="FInicio">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-1">
<div class="fw-bold text-secondary">* FECHA TERMINO:</div>
<input type="date" class="form-control rounded-0" id="FTermino">
</div>

</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="BuscarReporte(<?=$idEstacion;?>)">Buscar</button>
</div> 