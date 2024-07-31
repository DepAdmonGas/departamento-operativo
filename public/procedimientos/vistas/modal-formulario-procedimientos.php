<?php
require ('../../../app/help.php');
$idModulo = $_GET["idModulo"];

?>



<div class="modal-header">
  <h5 class="modal-title">Agregar procedimiento</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>

</div>


<div class="modal-body">

  <div class="row">

    <div class="col-12 mb-2">
      <div class="mb-1 text-secondary">Fecha:</div>
      <input type="date" class="form-control rounded-0" id="fechaProcedimiento">
    </div>

    <div class="col-12 mb-2">
      <div class="mb-1 text-secondary">Titulo:</div>
      <input type="text" class="form-control rounded-0" id="tituloProcedimiento">
    </div>

    <div class="col-12">
      <div class="mb-1 text-secondary">Documento:</div>
      <input class="form-control" type="file" id="ArchivoProcedimiento">
    </div>

  </div>

</div>


<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="agregarProcedimiento('<?= $idModulo ?>')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>