<?php
require('../../../../help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";  
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function NombrePersonal($id,$con){

$sql_personal = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre_completo'];	
}
return $return;
}

function NombreEstacion($id,$con){
$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id = '".$id."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$return = $row_listaestacion['localidad'];	
}
return $return;
}
?>


<div class="modal-header">
<h5 class="modal-title">Falta personal <?=$estacion;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">



    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-2">
<h6>* Nombre del empleado</h6>
	<select class="form-select" id="Empleado">
	<option></option>
	<?php 
	while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
	echo '<option value="'.$row_personal['id'].'">'.$row_personal['nombre_completo'].'</option>';
	}
	?>
	</select>
</div>

 <div class="col-xl-4 col-lg-8 col-md-8 col-sm-12 mb-2">
<h6>Días de falta:</h6>
<input type="number" class="form-control" id="DiasFalta">
</div>

 <div class="col-12">
<h6 class="mt-2">* Observaciónes</h6>
<textarea class="form-control" id="Observaciones"></textarea>
</div>


 <div class="col-12 mt-3">

<div class="border">
<div class="p-3">

<div class="text-end mb-2">
<button type="button" class="btn btn-primary btn-sm" onclick="GuardarFalta(<?=$idEstacion;?>,<?=$idReporte;?>)">Guardar falta</button>
</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">Nombre del empleado</th>
	<th class="align-middle text-center">Días de falta</th>
	<th class="align-middle text-center">Observaciónes</th>
	<th class="align-middle text-center" width="32"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar"></th>
	</tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle text-center">'.$personal.'</td>';
echo '<td class="align-middle text-center">'.$row_lista['dias_falta'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['observaciones'].'</td>';
echo '<td class="align-middle text-center pointer" onclick="EliminarFalta('.$id.','.$idReporte.','.$idEstacion.')"><img  src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
</div>
</div>



</div>
</div>

<div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="FinalizarFalta(<?=$idReporte;?>,<?=$idEstacion;?>)">Finalizar formulario</button>
</div> 