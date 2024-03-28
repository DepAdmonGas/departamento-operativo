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
<h5 class="modal-title">Agregar <?=$estacion;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Nombre completo:</small></div>
<input type="text" class="form-control mt-1" id="Personal">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Puesto:</small></div>
<input type="text" class="form-control mt-1" id="Puesto">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Fecha baja:</small></div>
<input type="date" id="Fecha" class="form-control mt-1">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Causa:</small></div>
<textarea class="form-control mt-1" id="Causa"></textarea>

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Motivo:</small></div>
<textarea class="form-control mt-1" id="Motivo"></textarea>

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Archivo:</small></div>
<input class="form-control" type="file" class="mt-1" id="Archivo">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">INE:</small></div>
<input class="form-control" type="file" class="mt-1" id="INE">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
</div>
 