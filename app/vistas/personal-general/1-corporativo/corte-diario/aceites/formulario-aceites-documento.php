<?php
require ('../../../../../help.php');
$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];
?>
<div class="modal-header">
    <h5 class="modal-title">Documentos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <h6 class="mb-2">* Ficha Deposito Faltante</h6>
    <input class="form-control" type="file" id="Ficha">
    <h6 class="mb-2 mt-2">* Imagen de Bodega</h6>
    <input class="form-control" type="file" id="Imagen">
    <h6 class="mb-2 mt-2">* Factura Venta Mostrador</h6>
    <input class="form-control" type="file" id="Factura">
</div>
<div class="modal-footer ">
    <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" onclick="Cancelar(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">
        <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar
    </button>
    <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="Guardar(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar
    </button>
</div>