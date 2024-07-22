<?php
require('../../../../help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
?>

<div class="modal-header">

<h5 class="modal-title">Agregar Organigrama <?=$estacion;?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-secondary"><small>El organigrama debe ser en imagen .PNG o .JPG</small></div>

<h6 class="mb-1 mt-2">* Organigrama</h6>
<input class="form-control" type="file" id="seleccionArchivos">

<h6 class="mt-2 mb-1">Observaciones</h6>
<textarea class="form-control" id="Observaciones"></textarea>

<div id="Mensaje mt-2"></div>

</div>

      <div class="modal-footer">
      <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idEstacion;?>)">
         <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
      </div>
 