<?php
require('../../../app/help.php');

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
?>

<h5 class="modal-title">Ajuste salarial <?=$estacion;?></h5>

<div><b>Lic. Alejandro Guzmán</b> <br> <b>Departamento de Recursos Humanos</b></div>
<div class="mt-2 mb-2">Por medio del presente, solicito su apoyo para el ajuste salarial al siguiente colaborador.</div>
<hr>


<div class="row">

<div class="col-12 mb-3"> 
<h6 class="mb-1">*Apartir del:</h6>
<input type="date" class="form-control" id="FechaA">
</div> 

<div class="col-12 mb-3"> 
<h6 class="mb-1">* Nombre del empleado</h6>
  <select class="form-select" id="Empleado">
  <option></option>
  <?php 
  while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
  echo '<option value="'.$row_personal['id'].'">'.$row_personal['nombre_completo'].'</option>';
  }
  ?>
</select>
</div>

<div class="col-12 mb-3"> 
<h6 class="mb-1">* Sueldo</h6>
<input type="number" class="form-control" id="Sueldo">
</div>


<div class="col-12"> 

<div class="border"> 
<div class="p-3"> 

<div class="text-end">
<button type="button" class="btn btn-primary btn-sm" onclick="GuardarAjuste(<?=$idEstacion;?>,<?=$idReporte;?>)">Guardar ajuste</button>
</div>

<hr>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
  <tr>
  <th>Apartir del</th>
  <th>Nombre del empleado</th>
  <th>Sueldo</th>
  <th class="align-middle text-center" width="32"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar"></th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle">'.$personal.'</td>';
echo '<td class="align-middle">$'.number_format($row_lista['sueldo'],2).'</td>';
echo '<td class="align-middle text-center" onclick="EliminarAjusteS('.$id.','.$idReporte.','.$idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>';
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


        <button type="button" class="btn btn-success" onclick="FinalizarAjuste(<?=$idReporte;?>,<?=$idEstacion;?>)">Finalizar formulario</button>
