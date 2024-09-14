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

 
<div class="mb-2">
<label class="text-secondary">* Nombre completo</label>
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

<div class="col-12 mb-2">
<label class="text-secondary">* Número de días a disfrutar:</label>
<input type="number" class="form-control" id="NumDias" >
</div>

<div class="col-12 mb-2">
<label class="text-secondary">* Del:</label>
<input type="date" class="form-control" id="FechaInicio">
</div>

<div class="col-12 mb-2">
<label class="text-secondary">* Al:</label>
<input type="date" class="form-control" id="FechaTermino">
</div>

<div class="col-12 mb-2">
<label class="text-secondary">* Regresando el:</label>
<input type="date" class="form-control" id="FechaRegreso">
</div>

<div class="col-12">
<label class="text-secondary">Observaciones:</label>
<textarea class="form-control" rows="3" id="Observaciones"></textarea>
</div>

</div>
</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
