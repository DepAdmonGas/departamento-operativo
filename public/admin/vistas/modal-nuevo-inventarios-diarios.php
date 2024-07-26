<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

?>
<div class="modal-header">
<h5 class="modal-title">Nuevo registro</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <label class="text-secondary">Sucursal</label>
  <input type="text" class="form-control mt-1 mb-3" id="Sucursal">
 
  <div class="row">
  
  <div class="col-12 mb-3">
  <div class="border p-3">

  <h6>INVENTARIOS REALES</h6>
  <hr>
  <div class="row">

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">Destino</label>
  <input type="number" class="form-control mb-2" id="Destino1">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">87 Oct</label>
  <input type="number" class="form-control mb-2" id="Oct871">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">91 Oct</label>
  <input type="number" class="form-control mb-2" id="Oct911">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">Diesel</label>
  <input type="number" class="form-control" id="Diesel1">
  </div>
  
  </div>
  </div>
  </div>

  
  <div class="col-12">
  <div class="border p-3">

  <h6>CAPACIDAD ALMACENAJE</h6>
  <hr>
  <div class="row">

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">Destino</label>
  <input type="number" class="form-control mb-2" id="Destino2">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">87 Oct</label>
  <input type="number" class="form-control mb-2" id="Oct872">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">91 Oct</label>
  <input type="number" class="form-control mb-2" id="Oct912">
  </div>

  <div class="col-xl-6 col-lg-3 col-md-12 col-sm-12">
  <label class="text-secondary mb-1">Diesel</label>
  <input type="number" class="form-control" id="Diesel2">
  </div>
  
  </div>
  </div>
  </div>
  
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
        <span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>

        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idReporte;?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

      </div>