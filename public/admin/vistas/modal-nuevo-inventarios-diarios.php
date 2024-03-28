<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

?>
<div class="modal-header">
<h5 class="modal-title">Nuevo registro</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <label class="text-secondary">Sucursal</label>
  <input type="text" class="form-control mb-3" id="Sucursal">
 
  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="border p-2 mb-2">
      <h6>INVENTARIOS REALES</h6>

      <label class="text-secondary mb-1">Destino</label>
      <input type="number" class="form-control mb-2" id="Destino1">

      <label class="text-secondary mb-1">87 Oct</label>
      <input type="number" class="form-control mb-2" id="Oct871">

      <label class="text-secondary mb-1">91 Oct</label>
      <input type="number" class="form-control mb-2" id="Oct911">

      <label class="text-secondary mb-1">Diesel</label>
      <input type="number" class="form-control" id="Diesel1">

    </div>
    </div>
   
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
     
      <div class="border p-2 ">
      <h6>CAPACIDAD ALMACENAJE</h6>

      <label class="text-secondary mb-1">Destino</label>
      <input type="number" class="form-control mb-2" id="Destino2">

      <label class="text-secondary mb-1">87 Oct</label>
      <input type="number" class="form-control mb-2" id="Oct872">

      <label class="text-secondary mb-1">91 Oct</label>
      <input type="number" class="form-control mb-2" id="Oct912">

      <label class="text-secondary mb-1">Diesel</label>
      <input type="number" class="form-control" id="Diesel2">
      </div>
      </div>
      </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idReporte;?>)">Guardar</button>
      </div>