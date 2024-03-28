<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}
?>


<div class="modal-header">
<h5 class="modal-title">Agregar lista negra <?=$estacion;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div><small class="text-secondary fs-6 fw-bold">Nombre completo:</small></div>
<input type="text" class="form-control mt-1" id="Personal">

<div class="mt-3"><small class="text-secondary fs-6 fw-bold">Puesto:</small></div>
<input type="text" class="form-control mt-1" id="Puesto">

<div class="mt-3"><small class="text-secondary fs-6 fw-bold">Causa:</small></div>
<textarea class="form-control mt-1" id="Causa"></textarea>

<div class="mt-3"><small class="text-secondary fs-6 fw-bold">Motivo:</small></div>
<textarea class="form-control mt-1" id="Motivo"></textarea>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
</div>
 