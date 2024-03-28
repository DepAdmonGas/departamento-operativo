<?php
require('../../../app/help.php');

?> 


<div class="modal-header">
<h5 class="modal-title">Buscar Acuses de Recepción</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body"> 

Seleccione:
<select class="form-control rounded-0" id="Buscar">
	<option value="0">Todas</option>
	<option value="1">Pendientes</option>
	<option value="2">Finalizadas</option>

</select>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="BTNBuscar()">Finalizar</button>
</div>