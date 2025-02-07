<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar empleado</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

 
<div class="mb-3">
<div class="fw-bold text-secondary">* NOMBRE COMPLETO:</div>
<select class="form-select rounded-0" id="Personal">
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

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* NUMERO DE DIAS A DISFRUTAR:</div>
<input type="number" class="form-control" id="NumDias" >
</div>

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* DEL:</div>
<input type="date" class="form-control" id="FechaInicio">
</div>

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* AL:</div>
<input type="date" class="form-control" id="FechaTermino">
</div>

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* REGRESANDO EL:</div>
<input type="date" class="form-control" id="FechaRegreso">
</div>

<div class="col-12">
<div class="text-secondary">OBSERVACIONES:</div>
<textarea class="form-control" rows="3" id="Observaciones"></textarea>
</div>

</div>
</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
