<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
?>
<div class="modal-header">
    <h5 class="modal-title">Nuevo</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <div class="text-secondary fw-bold">* FECHA:</div>
    <input type="date" class="mb-2 form-control rounded-0" id="Fecha" value="<?=$fecha_del_dia?>">

    <div class="text-secondary fw-bold">* FACTURA:</div>
    <input type="text" class="mb-2 form-control rounded-0" id="Factura">

    <div class="text-secondary fw-bold">* NETO:</div>
    <input type="number" step="any" class="mb-2 form-control rounded-0" id="Neto">

    <div class="text-secondary fw-bold">* BRUTO</div>
    <input type="number" step="any" class="mb-2 form-control rounded-0" id="Bruto">

    <div class="text-secondary fw-bold">* CUENTA LITROS</div>
    <input type="number" step="any" class="mb-2 form-control rounded-0" id="CuentaLitros">

    <div class="text-secondary fw-bold">* PROVEEDOR:</div>
    <select class="form-select rounded-0" id="Proveedor">
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