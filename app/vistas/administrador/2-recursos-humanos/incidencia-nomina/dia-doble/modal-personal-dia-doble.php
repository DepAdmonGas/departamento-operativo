<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

?>

<div class="modal-header">
<h5 class="modal-title">Agregar personal</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

 
<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* NOMBRE DEL PERSONAL:</div>
<select class="form-select rounded-0" id="NombresCompleto">
<option value="">Selecciona una opción...</option>
<?php 
$sql_puesto = "SELECT id, nombre_completo FROM op_rh_personal WHERE id_estacion = 11 AND estado = 1 ORDER BY nombre_completo ASC";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
echo '<option value='.$row_puesto['id'].'>'.$row_puesto['nombre_completo'].'</option>';
}
?> 
</select>
</div>   

<div class="col-12">
<div class="fw-bold text-secondary">* DIA DOBLE:</div>
<input type="date" class="form-control rounded-0" id="FechaDiaDoble">
</div>


</div>
</div>
 

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
