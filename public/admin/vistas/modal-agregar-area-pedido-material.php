<?php
require('../../../app/help.php');

$idPedido = $_GET['idPedido'];
?>
<div class="modal-header">
  <h5 class="modal-title">Área</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <label class="text-secondary">* Área</label>
  <input type="text" class="form-control rounded-0" min="0" id="Area">

</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary rounded-0" onclick="AgregarArea(<?=$idPedido;?>)">Agregar</button>
</div>
