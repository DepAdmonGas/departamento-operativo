<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>

      <div class="modal-header">
        <h5 class="modal-title">Agregar comprobante de pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

<h5 class="mb-3">Periodo</h5>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-1 mb-2"> 
<h6>Fecha inicio</h6>
<input type="date" class="form-control" id="MFInicio">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-1 mb-2"> 
<h6>Fecha termino</h6>
<input type="date" class="form-control" id="MFTermino">
</div>

</div>

<hr>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
  <h6 class="mb-1">Agregar factura PDF</h6>
<input class="form-control" type="file" id="PDF">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<h6 class="mb-1">Agregar factura XML</h6>
<input class="form-control" type="file" id="XML">
</div>

</div>

<div class="text-danger">Nota: Usu del <b>CFDI</b> es <b>Gastos en general</b> y la forma de pago es <b>PPD</b></div>
</div>

      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
      </div>

