<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>
<div class="modal-header">
<h5 class="modal-title">Agregar terminal punto de venta</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>

</div>


      <div class="modal-body">

        <div class="row">


          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
          <div class="mb-1 text-secondary fw-bold">* TPV:</div>
          <input type="text" class="form-control rounded-0" id="Tpv">  
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary fw-bold">* NO. SERIE:</div>
          <input type="text" class="form-control rounded-0" id="Serie">
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary fw-bold">* MODELO/MARCA:</div>
          <input type="text" class="form-control rounded-0" id="Modelomarca">
          </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

          <div class="mb-1 text-secondary fw-bold">* NO. LOTE:</div>
          <input type="text" class="form-control rounded-0" id="NoLote">
          </div>
          
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary fw-bold">* TIPO CONEXIÓN:</div>
          <input type="text" class="form-control rounded-0" id="TipoC">
          </div>
        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* NUMERO AFILIACIÓN</div>
        <input type="text" class="form-control rounded-0" id="Afiliado">
        </div>

       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* TELEFONO ATENCIÓN</div>
        <input type="text" class="form-control rounded-0" id="Telefono">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* ACTIVAS:</div>
        <input type="text" class="form-control rounded-0" id="Estado">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* ROLLOS:</div>
        <input type="text" class="form-control rounded-0" id="Rollos">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* CARGADORES:</div>
        <input type="text" class="form-control rounded-0" id="Cargadores">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* PEDESTALES EN BUEN ESTADO:</div>
        <input type="text" class="form-control rounded-0" id="Pedestales">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* ESTADO TPV'S:</div>    
          <select class="form-select" id="EstadoTPV">
            <option></option>
            <option>Nuevo</option>
            <option>Usado</option>
            <option>Reparación</option>
          </select>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* NO. DE IMPRESIONES:</div>
        <input type="number" class="form-control rounded-0" id="NoImpresiones">
        </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">* TIPO TPV'S:</div>
          <select class="form-select" id="TipoTPV">
            <option></option>
            <option>Tecla</option>
            <option>Touch</option>
          </select>
        </div>

        </div>
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idEstacion?>)">
      <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

      </div>