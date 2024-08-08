<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$id = $_GET['id'];
?>

<div class="modal-header">
<h5 class="modal-title">Documentos</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
        <div class="mb-1 text-secondary">Ficha deposito faltante</div>
        <input class="form-control" type="file" id="Ficha">

        <div class="mb-1 mt-2 text-secondary">Imagen de bodega</div>
        <input class="form-control" type="file" id="Imagen">

        <div class="mb-1 mt-2 text-secondary">Factura venta mostrador</div>
        <input class="form-control" type="file" id="Factura">

</div>



<div class="modal-footer">

	 <button type="button" class="btn btn-labeled2 btn-danger" onclick="Cancelar(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>)">
         <span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>

         <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarInfo(<?=$IdReporte;?>,<?=$year;?>,<?=$mes;?>,<?=$id;?>)"> 
         <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>

</div>