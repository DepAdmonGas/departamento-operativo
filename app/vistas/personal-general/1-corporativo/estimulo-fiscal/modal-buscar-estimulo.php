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
<h6>* Fecha inicio:</h6>
<input type="date" class="form-control" id="FInicio">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mt-1">
<h6>* Fecha termino:</h6>
<input type="date" class="form-control" id="FTermino">
</div>

</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="BuscarReporte(<?=$idEstacion;?>)">Buscar</button>
</div> 