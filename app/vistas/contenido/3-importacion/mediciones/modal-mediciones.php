<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
?>
<div class="modal-header">
    <h5 class="modal-title">Nuevo</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <h6 class="mb-1"> * Fecha</h6>
    <input type="date" class="mb-2 form-control" id="Fecha" value="<?=$fecha_del_dia?>">

    <h6 class="mb-2">* Factura</h6>
    <input type="text" class="mb-2 form-control" id="Factura">

    <h6 class="mb-2">* Neto</h6>
    <input type="number" step="any" class="mb-2 form-control" id="Neto">

    <h6 class="mb-2">* Bruto</h6>
    <input type="number" step="any" class="mb-2 form-control" id="Bruto">

    <h6 class="mb-2">* Cuenta litros</h6>
    <input type="number" step="any" class="mb-2 form-control" id="CuentaLitros">

    <h6 class="mb-2">* Proveedor</h6>
    <select class="form-select" id="Proveedor">
        <option></option>
        <option>Pemex</option>
        <option>Delivery</option>
        <option>Pick Up</option>
    </select>


</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idEstacion?>)">  
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>