<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>
<div class="modal-header">
<h5 class="modal-title">Agregar terminal punto de venta</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>


      <div class="modal-body">

        <div class="row">


          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
          <div class="mb-1 text-secondary">TPV:</div>
          <input type="text" class="form-control rounded-0" id="Tpv">  
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary">No. Serie:</div>
          <input type="text" class="form-control rounded-0" id="Serie">
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary">Modelo/Marca:</div>
          <input type="text" class="form-control rounded-0" id="Modelomarca">
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary">No. Lote:</div>
          <input type="text" class="form-control rounded-0" id="NoLote">
          </div>
          
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Tipo Conexión:</div>
          <input type="text" class="form-control rounded-0" id="TipoC">
          </div>
        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Numero afiliación:</div>
        <input type="text" class="form-control rounded-0" id="Afiliado">
        </div>

       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Telefono atención:</div>
        <input type="text" class="form-control rounded-0" id="Telefono">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Activas:</div>
        <input type="text" class="form-control rounded-0" id="Estado">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Rollos:</div>
        <input type="text" class="form-control rounded-0" id="Rollos">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Cargadores:</div>
        <input type="text" class="form-control rounded-0" id="Cargadores">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Pedestales en buen estado:</div>
        <input type="text" class="form-control rounded-0" id="Pedestales">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Estado TPV'S:</div>    
          <select class="form-select" id="EstadoTPV">
            <option></option>
            <option>Nuevo</option>
            <option>Usado</option>
            <option>Reparación</option>
          </select>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">No. de Impresiones:</div>
        <input type="number" class="form-control rounded-0" id="NoImpresiones">
        </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Tipo TPV'S:</div>
          <select class="form-select" id="TipoTPV">
            <option></option>
            <option>Tecla</option>
            <option>Touch</option>
          </select>
        </div>

 

        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
      </div>