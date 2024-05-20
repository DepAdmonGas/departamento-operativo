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

$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id <= 7 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

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
<h5 class="modal-title">Cambio y restructuración de personal <?=$estacion;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">


    <div class="row">

   	<div class="col-12 mb-3">
	<span class="badge rounded-pill tables-bg float-end" style="font-size:12.2px">No. De control: 010</span>
	</div>

    <div class="col-xl-6 col-lg-6 col-md-11 col-sm-12 mb-2">
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

    <div class="col-xl-6 col-lg-6 col-md-11 col-sm-12 mb-2">
		<h6>* Cambio a</h6>
		<select class="form-select" id="Estacion">
		<option></option>
		<?php 
		while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
		echo '<option value="'.$row_listaestacion['id'].'">'.$row_listaestacion['localidad'].'</option>';
		}
		?>
		</select>
	</div>

    <div class="col-xl-6 col-lg-6 col-md-11 col-sm-12 mb-2">
	<h6>* Salario diario:</h6>
	<input type="number" class="form-control" id="SalarioD">
	</div>


    <div class="col-xl-6 col-lg-6 col-md-11 col-sm-12 mb-2">
	<h6>* A partir de día:</h6>
	<input type="date" class="form-control" id="Fecha">
	</div>


	<div class="col-12 mb-2">
<h6 class="mt-1">* Detalle</h6>
<textarea class="form-control" id="Detalle"></textarea>
</div>



<div class="col-12 mt-2">
<div class="border">
<div class="p-3">

<div class="text-end">
<button type="button" class="btn btn-primary btn-sm" onclick="GuardarRestructuracion(<?=$idEstacion;?>,<?=$idReporte;?>)">Guardar cambio de personal</button>
</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead>
	<tr class="tables-bg">
		<th>Nombre del empleado</th>
		<th class="align-middle text-center">Cambio a</th>
		<th class="align-middle text-end">Salario diario</th>
		<th class="align-middle text-center">A partir de</th>
		<th class="align-middle text-center">Detalle</th>
		<th class="align-middle text-center"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar"></th>
	</tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);
$estacion = NombreEstacion($row_lista['id_estacion'],$con);

echo '<tr>';
echo '<td class="align-middle">'.$personal.'</td>';
echo '<td class="align-middle">'.$estacion.'</td>';
echo '<td class="align-middle text-end">'.number_format($row_lista['sd'],2).'</td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center" onclick="EliminarRestructuracion('.$id.','.$idReporte.','.$idEstacion.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>';
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
<button type="button" class="btn btn-success" onclick="FinalizarRestructuracion(<?=$idReporte;?>,<?=$idEstacion;?>)">Finalizar formulario</button>
</div> 