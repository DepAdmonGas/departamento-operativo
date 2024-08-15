<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
?>

<div class="modal-header">
<h5 class="modal-title">Agregar factura</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>      </div>
      
<div class="modal-body">

<div class="mb-1 text-secondary">* Detalle</div>
<select class="form-select" id="Detalle">
<option value="">Selecciona una opción...</option>
<option value="Factura">Factura</option>
<option value="Pago">Pago</option>
<option value="Nota de crédito">Nota de crédito</option>
<option value="Otros">Otros</option>
<option value="Estado de cuenta">Estado de cuenta</option>
<option value="XML">XML</option>     
</select>
        
<div class="mb-1 text-secondary mt-2">* Agregar factura Telcel</div>
<input class="form-control" type="file" id="Documento">

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$IdReporte;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>