<?php
require('../../../app/help.php');

$idBaja = $_GET['idBaja'];
$idEstacion = $_GET['idEstacion'];

?> 

<div class="modal-header">
<h5 class="modal-title">Documentos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="row">

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">Descripción:</div>
    <input type="text" list="DataList" class="form-control rounded-0" id="DescripcionArchivo">
      <datalist id="DataList">
        <option>Acta de hechos</option>
        <option>Carta de Renuncia</option>
        <option>Finiquito</option>
      </datalist>
  </div>
 
  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary">Archivo:</div>
  <input type="file" class="form-control" id="Archivo">
  </div>

  </div>

</div>
    
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="subirArchivoBaja(<?=$idBaja;?>,<?=$idEstacion?>)">Guardar</button>
</div>