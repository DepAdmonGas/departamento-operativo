<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
  <h5 class="modal-title">Agregar proveedor</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary">Razón Social:</div>
  <input type="text" class="form-control" id="RazonSocial">

  <div class="mb-1 mt-2 text-secondary">Dirección:</div>
  <textarea class="form-control" id="Direccion"></textarea>

  <div class="mb-1 mt-2 text-secondary">Contacto:</div>
  <input type="text" class="form-control" id="Contacto">

  <div class="mb-1 mt-2 text-secondary">Email:</div>
  <input type="text" class="form-control" id="Email">


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="AgregarProveedor(<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>