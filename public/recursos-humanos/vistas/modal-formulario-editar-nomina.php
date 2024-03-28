<?php
require('../../../app/help.php');

$id = $_GET['id'];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$semana = $_GET['semana'];
$idPersonal = $_GET['idPersonal'];

$esdep = $_GET['esdep'];


if($semana == 1){
  $nombreSemana = "Primera semana";

}else if($semana == 2){
  $nombreSemana = "Segunda semana";

}else if($semana == 3){
  $nombreSemana = "Tercera semana";

}else if($semana == 4){
  $nombreSemana = "Cuarta semana";

}else if($semana == 5){
  $nombreSemana = "Quinta semana";

}else if($semana == 6){
  $nombreSemana = "Primera quincena";

}else if($semana == 7){
  $nombreSemana = "Segunda quincena";

}else if($semana == 8){
  $nombreSemana = "Aguinaldo";
}

$esdep = $_GET['esdep'];

if($esdep != 0){
$idDpto = $esdep;

}else{
$idDpto = 0;	

}


$sql_lista = "SELECT * FROM op_recibo_nomina WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$periodo = $row_lista['periodo'];
}
 

?>

<div class="modal-header">
<h5 class="modal-title">Agregar recibo de nomina</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
 

<?php

if($idPersonal == 0){

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.no_colaborador,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_puestos.puesto
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.no_colaborador ASC ";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
?>



<div class="table-responsive">
<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
	<th class="text-center align-middle">No. <br>Colaborador</th>
	<th class="align-middle">Nombre completo</th>
	<th class="align-middle">Puesto</th>
	</tr>
</thead> 
<tbody>
<?php 
if ($numero_personal > 0) {
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$no_colaborador = $row_personal['no_colaborador'];

if($no_colaborador == 0){
  $numColab = "S/I";
}else{
  $numColab = $no_colaborador;
}

echo '<tr>
<td class="text-center">'.$numColab.'</td>
<td class="text-center">'.$row_personal['nombre_completo'].'</td>
<td class="text-center">'.$row_personal['puesto'].'</td>
</tr>';

}
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar</small></td></tr>";
}
?>
</tbody>
</table>
</div>



<?php
}else{

$sql_personal = "SELECT
op_recibo_nomina.id_personal_nomina,
op_recibo_nomina.percepciones,
op_recibo_nomina.deducciones,
op_recibo_nomina.isr,
op_recibo_nomina.isr_retenido,
op_recibo_nomina.total,

op_rh_personal.no_colaborador,
op_rh_personal.nombre_completo,

op_rh_personal.puesto AS idPuesto,
op_rh_puestos.puesto

FROM op_recibo_nomina

INNER JOIN op_rh_personal ON op_recibo_nomina.id_personal_nomina = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id

WHERE op_rh_personal.id = '".$idPersonal."' AND op_recibo_nomina.periodo = '".$nombreSemana."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC limit 1;";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
	<th class="text-center align-middle">No. <br>Colaborador</th>
	<th class="align-middle">Nombre completo</th>
	<th class="align-middle">Puesto</th>
	  <th class="text-center align-middle tableStyle font-weight-bold">Percepciones</th>
	  <th class="text-center align-middle tableStyle font-weight-bold">Deducciones</th>
	  <th class="text-center align-middle tableStyle font-weight-bold">ISR</th>
	  <th class="text-center align-middle tableStyle font-weight-bold">ISR (Retenido)</th>
	  <th class="text-center align-middle tableStyle font-weight-bold">Total</th> 
	</tr>
</thead> 
<tbody>
<?php 
if ($numero_personal > 0) {
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$no_colaborador = $row_personal['no_colaborador'];

if($no_colaborador == 0){
  $numColab = "S/I";
}else{
  $numColab = $no_colaborador;
}

echo '<tr>
<td class="text-center align-middle">'.$numColab.'</td>
<td class="text-center align-middle">'.$row_personal['nombre_completo'].'</td>
<td class="text-center align-middle">'.$row_personal['puesto'].'</td>

<td class="text-center align-middle">'.$row_personal['percepciones'].'</td>
<td class="text-center align-middle">'.$row_personal['deducciones'].'</td>
<td class="text-center align-middle">'.$row_personal['isr'].'</td>
<td class="text-center align-middle">'.$row_personal['isr_retenido'].'</td>
<td class="text-center align-middle">'.$row_personal['total'].'</td>

</tr>';

}
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar</small></td></tr>";
}
?>
</tbody>
</table>
</div>




<?php
}
?>










<div class="border p-3">
<h5><?=$periodo;?></h5>
<hr>
<div class="mb-2 text-secondary mt-2">Documento:</div>
<input class="form-control" type="file" id="Documento">
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button type="button" class="btn btn-success" onclick="EditarDocumento(<?=$id;?>,<?=$idEstacion;?>,<?=$idDpto?>,<?=$year;?>,<?=$mes;?>,<?=$semana;?>,<?=$idPersonal;?>)">Agregar</button>
</div>


