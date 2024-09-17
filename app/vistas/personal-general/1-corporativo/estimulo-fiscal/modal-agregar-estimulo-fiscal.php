<?php
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar comprobante de pago</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<h5>PERIODO</h5>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">* FECHA INICIO:</div>
<input type="date" class="form-control rounded-0" id="MFInicio">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">* FECHA TERMINO</div>
<input type="date" class="form-control rounded-0" id="MFTermino">
</div>

</div>

<hr>

<div class="row">

<div class="col-12 mb-2"> 
<div class="mt-2 fw-bold text-secondary">* AGREGAR FACTURA PDF:</div>
<input type="file" class="form-control rounded-0" id="PDF">
</div>

<div class="col-12 mb-2"> 
<div class="mt-2 fw-bold text-secondary">* AGREGAR FACTURA XML:</div>
<input type="file" class="form-control rounded-0" id="XML">
</div>

</div>


<div class="text-danger mt-3">NOTA: USO DEL CFDI ES GASTOS EN GENERAL Y LA FORMA DE PAGO ES PPD</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
</div> 