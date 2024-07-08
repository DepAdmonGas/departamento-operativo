 <?php
require('../../../app/help.php');
$idCuentaLitros = $_GET['idCuentaLitros'];

?>

    <div class="modal-header">
    <h5 class="modal-title">Editar fecha</h5>  
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>


    <div class="modal-body">
 	<div class="mb-1 text-secondary">Fecha:</div>
    <input class="form-control" type="date" id="fechaCL">
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-primary rounded-0" onclick="editarFechaCL(<?=$idCuentaLitros?>)">Guardar</button>
    </div>