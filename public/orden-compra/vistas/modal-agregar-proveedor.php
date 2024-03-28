<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
<h5 class="modal-title">Agregar proveedor</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="AgregarProveedor(<?=$idReporte;?>)">Agregar</button>
      </div>
