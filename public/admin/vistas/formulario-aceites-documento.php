<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];
?>

      <div class="modal-header">
        <h5 class="modal-title">Documentos</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-1 text-secondary">FICHA DEPOSITO FALTANTE</div>
        <input class="form-control" type="file" id="Ficha">

        <div class="mb-1 mt-3 text-secondary">IMAGEN DE BODEGA</div>
        <input class="form-control" type="file" id="Imagen">

        <div class="mb-1 mt-3 text-secondary">FACTURA VENTA MOSTRADOR</div>
        <input class="form-control" type="file" id="Factura">
</div>


<div class="modal-footer ">
    <button type="button" class="btn btn-labeled2 btn-danger" onclick="Cancelar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">
        <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar
    </button>

    <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar
    </button>
</div>


 