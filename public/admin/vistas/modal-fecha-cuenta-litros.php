 <?php
require('../../../app/help.php');
$idCuentaLitros = $_GET['idCuentaLitros'];

?>

    <div class="modal-header">
    <h5 class="modal-title">Editar fecha</h5>  
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>


    <div class="modal-body">
 	<div class="mb-1 text-secondary fw-bold">* FECHA:</div>
    <input class="form-control rounded-0" type="date" id="fechaCL">
    </div>

    <div class="modal-footer">
    <button type="button" class="btn btn-labeled2 btn-success" onclick="editarFechaCL(<?=$idCuentaLitros?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

    </div>