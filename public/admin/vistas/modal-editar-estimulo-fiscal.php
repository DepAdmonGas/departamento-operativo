<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$IdReporte = $_GET['IdReporte'];
$FInicio = $_GET['FechaInicio'];
$FTermino = $_GET['FechaTermino'];
?>

      <div class="modal-header">
        <h5 class="modal-title">Editar comprobante de pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

<h5 class="mb-3">Periodo</h5>



<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 

<h6>Fecha inicio</h6>
<input type="date" class="form-control" id="EFInicio">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 

<h6>Fecha termino</h6>
<input type="date" class="form-control" id="EFTermino">
</div>

</div>

<hr>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<h6 class="mt-2">Agregar factura PDF</h6>
<input type="file" class="form-control" id="EPDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<h6 class="mt-2">Agregar factura XML</h6>
<input type="file" class="form-control" id="EXML">
</div>

</div>

<hr>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<h6 class="mt-2">Agregar complemento PDF</h6>
<input type="file" class="form-control" id="CPDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
<h6 class="mt-2">Agregar complemento XML</h6>
<input type="file" class="form-control" id="CXML">
</div>

</div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="EditarPago(<?=$idEstacion;?>,<?=$IdReporte;?>,'<?=$FInicio;?>','<?=$FTermino;?>')">Guardar</button>
      </div>