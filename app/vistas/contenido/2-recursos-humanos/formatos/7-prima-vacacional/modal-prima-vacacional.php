<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar colaborador</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* COLABORADOR:</div>
<select class="form-select rounded-0" id="NombresCompleto">
<option value="">Selecciona una opción...</option>
<?php 
$sql_puesto = "SELECT id, nombre_completo FROM op_rh_personal WHERE id_estacion = '".$idEstacion."' AND estado = 1";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
echo '<option value='.$row_puesto['id'].'>'.$row_puesto['nombre_completo'].'</option>';
}
?> 
</select>
</div>   


<div class="col-12">
<div class="fw-bold text-secondary">* PERIODO:</div>
<select class="form-select rounded-0" id="Periodo">
<option value="">Selecciona una opción...</option>
<?php
for ($i = $fecha_year; $i >= 2020; $i--) {
$year = $i;
echo '<option value='.$year.'>'.$year.'</option>';
}
?> 
</select>
</div>   


</div>
</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
