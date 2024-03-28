<?php
require('../../../app/help.php');
?>

<div class="modal-header">
<h5 class="modal-title">Agregar terminal punto de venta</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      
      <div class="modal-body">

        <div class="row">

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
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

        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar()">Guardar</button>
      </div>