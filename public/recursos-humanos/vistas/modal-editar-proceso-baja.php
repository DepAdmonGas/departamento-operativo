 <?php
require('../../../app/help.php');

$idBaja = $_GET['idBaja'];
$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT proceso, estado_proceso FROM op_rh_personal_baja WHERE id = '".$idBaja."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$proceso = $row_listaestacion['proceso'];
$EstadoProceso = $row_listaestacion['estado_proceso'];

	if($row_listaestacion['estado_proceso'] == 0){
		$estado = "Pendiente";
	}else if($row_listaestacion['estado_proceso'] == 1){
		$estado = "En Proceso";
	}else if($row_listaestacion['estado_proceso'] == 2){
		$estado = "Finalizado";
	}

}

?>
<div class="modal-header">
<h5 class="modal-title">Editar proceso de baja</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">


<div class="col-12 mb-2">
	<h6>* Proceso de baja</h6>

	 <input type="text" list="DataList" class="form-control mt-1" id="Proceso" value="<?=$proceso?>">
      <datalist id="DataList">
		<option>Finiquito</option>
		<option>Junta de conciliacion y arbitraje</option>
		<option>Demanda</option>
      </datalist>

</div> 

</div>

	<h6>* Status</h6>
	<select class="form-select" id="Status">
	<option value="<?=$EstadoProceso;?>"><?=$estado?></option>
	<option value="0">Pendiente</option>
	<option value="1">En Proceso</option>
	<option value="2">Finalizado</option>
	</select>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="EditarProcesoPersonal(<?=$idBaja;?>,<?=$idEstacion;?>)">Editar</button>
</div>

 