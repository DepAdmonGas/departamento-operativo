<?php
require('../../../app/help.php');
$tipo = $_GET['tipo'];

?>


<div class="modal-header">
  <h5 class="modal-title">Agregar <?=$tipo?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 

<div class="modal-body">

<div class="text-secondary mb-1">Fecha:</div>
<input type="date" class="form-control rounded-0 mb-2" id="Fecha">

<div class="text-secondary mb-1">Descripción:</div>
<input type="text" class="form-control rounded-0 mb-2" id="Descripcion">

<div class="text-secondary mb-1">Archivo:</div>
<input type="file" class="form-control rounded-0 mb-2" id="Archivo">

</div> 


<div class="modal-footer">
  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary rounded-0" onclick="AgregarDocumento('<?=$tipo?>')">Agregar</button>
</div>
