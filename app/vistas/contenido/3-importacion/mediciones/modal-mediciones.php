<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
?>
<div class="modal-header">
    <h5 class="modal-title">Nuevo</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <div class="mb-1"><small>* Fecha</small></div>
    <input type="date" class="mb-2 form-control" id="Fecha" value="<?=$fecha_del_dia?>">

    <div class="mb-1"><small>* Factura</small></div>
    <input type="text" class="mb-2 form-control" id="Factura">

    <div class="mb-1"><small>* Neto</small></div>
    <input type="number" step="any" class="mb-2 form-control" id="Neto">

    <div class="mb-1"><small>* Bruto</small></div>
    <input type="number" step="any" class="mb-2 form-control" id="Bruto">

    <div class="mb-1"><small>* Cuenta litros</small></div>
    <input type="number" step="any" class="mb-2 form-control" id="CuentaLitros">

    <div class="mb-1"><small>* Proveedor</small></div>
    <select class="form-select" id="Proveedor">
        <option></option>
        <option>Pemex</option>
        <option>Delivery</option>
        <option>Pick Up</option>
    </select>


</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion?>)">Guardar</button>
</div>