<?php
require('../../../app/help.php');

?>
<div class="modal-header">
<h5 class="modal-title">Agregar Firma electrónica</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
      <div class="modal-body">

      	<div class="mb-2 mt-2 text-secondary"><b>Usuario:</b></div>
        <input type="text" class="form-control rounded-0" autocomplete="off" placeholder="Usuario" id="Usuario">

        <div class="mb-2 mt-2 text-secondary"><b>Contraseña:</b></div>
        <input type="password" class="form-control rounded-0" autocomplete="off" placeholder="Contraseña" id="Password">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="CrearFirma()">Crear Firma</button>
      </div>
