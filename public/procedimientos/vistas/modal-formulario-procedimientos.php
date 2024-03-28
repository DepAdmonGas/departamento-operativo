<?php
require('../../../app/help.php');
$idModulo = $_GET["idModulo"];

?>



 <div class="modal-header">
<h5 class="modal-title">Agregar procedimiento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

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
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-success" onclick="agregarProcedimiento('<?=$idModulo?>')">Agregar</button>
  </div> 