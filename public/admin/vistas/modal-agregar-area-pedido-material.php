<?php
require('../../../app/help.php');

$idPedido = $_GET['idPedido'];
?>
<div class="modal-header">
  <h5 class="modal-title">Área</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <label class="text-secondary fw-bold">* ÁREA</label>
  <input type="text" class="form-control rounded-0" min="0" id="Area">

</div>

<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
         <span class="btn-label2"><i class="fa-regular fa-circle-xmark"></i></span>Cancelar</button>

  <button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarArea(<?=$idPedido;?>)">
    <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>
