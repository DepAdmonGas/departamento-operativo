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
<h5 class="modal-title">Formulario incapacidad de personal <?=$estacion;?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
 
<div class="col-12 mb-3">
 <span class="badge rounded-pill tables-bg float-end" style="font-size:12.2px">No. De control: 011</span>
</div>


<h6 class="mb-1">* Nombre del empleado</h6>
<select class="form-select"></select>

<h6 class="mt-2 mb-1">* Detalle</h6>
<textarea class="form-control"></textarea>


<div class="border"> 
<div class="p-3"> 

<div class="text-end">
<button type="button" class="btn btn-primary btn-sm" onclick="Guardar(<?=$idEstacion;?>)">Guardar incapacidad de personal</button>
</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
		<th>Nombre completo</th>
		<th>Detalle</th>
	</tr>
</thead> 
<tbody>
	<tr>
		<td></td>
		<td></td>
	</tr>
</tbody>
</table>
</div>

</div>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-success btn-sm" onclick="Guardar(<?=$idEstacion;?>)">Finalizar formulario</button>
</div> 