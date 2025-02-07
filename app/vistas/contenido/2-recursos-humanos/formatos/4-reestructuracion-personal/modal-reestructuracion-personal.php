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

 
<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* NOMBRE DEL EMPLEADO:</div>
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

<div class="col-12 mb-3">
<div class="fw-bold text-secondary">* CAMBIO A:</div>
<select class="form-select rounded-0" id="NombreEstacion">
<option value="">Selecciona una opción...</option>
<?php 
$sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17  ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){

if($row_listaestacion['id'] != $idEstacion){
echo '<option value='.$row_listaestacion['id'].'>'.$row_listaestacion['localidad'].'</option>';
}

}
?> 
</select>
</div>  

<div class="col-12">
<div class="fw-bold text-secondary">* FECHA DE APLIACACIÓN:</div>
<input type="date" class="form-control rounded-0" id="FechaAplicacion">
</div>


</div>
</div>
 

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="agregarPersonal(<?=$idReporte?>,<?=$idEstacion?>)"><span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
