<?php
require('../../../../../app/help.php');
$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$datosEstimuloFiscal = $corteDiarioGeneral->obtenerDatosEstimuloFiscal($IdReporte);
$fecha_inicio = $datosEstimuloFiscal['fecha_inicio'];
$fecha_termino = $datosEstimuloFiscal['fecha_termino'];

?>

<div class="modal-header">
<h5 class="modal-title">Editar comprobante de pago</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<h5 class="mb-3">PERIODO</h5>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">* FECHA INICIO:</div>
<input type="date" class="form-control rounded-0" id="EFInicio" value="<?=$fecha_inicio?>">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="fw-bold text-secondary">* FECHA TERMINO:</div>
<input type="date" class="form-control rounded-0" id="EFTermino" value="<?=$fecha_termino?>">
</div>

</div>

<hr>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="mt-2 text-secondary">AGREGAR FACTURA PDF:</div>
<input type="file" class="form-control rounded-0" id="EPDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="mt-2 text-secondary">AGREGAR FACTURA XML:</div>
<input type="file" class="form-control rounded-0" id="EXML">
</div>

</div>

<hr>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="mt-2 text-secondary">AGREGAR COMPLEMENTO PDF:</div>
<input type="file" class="form-control rounded-0" id="CPDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<div class="mt-2 text-secondary">AGREGAR COMPLEMENTO XML:</div>
<input type="file" class="form-control rounded-0" id="CXML">
</div>

</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="EditarPago(<?=$IdReporte;?>,<?=$idEstacion;?>)">Guardar</button>
</div>