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
<label class="text-secondary">* Nombre completo:</label>
<input type="text" class="form-control rounded-0" id="NombresCompleto">
</div>
 
<div class="mb-2">
<label class="text-secondary">* Puesto</label>
<select class="form-select rounded-0" id="Puesto">
<option value="">Selecciona una opción...</option>
<?php 
$sql_puesto = "SELECT id, puesto FROM op_rh_puestos ";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
echo '<option value='.$row_puesto['id'].'>'.$row_puesto['puesto'].'</option>';
}
?> 
</select>
</div>   

<div class="col-12 mb-2">
<label class="text-secondary">* Fecha de alta:</label>
<input type="date" class="form-control rounded-0" id="FechaIngreso">
</div>

<div class="col-12">
<label class="text-secondary">* Salario Diario:</label>
<input type="number" class="form-control rounded-0" id="sd" >
</div>
	
</div>
</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>