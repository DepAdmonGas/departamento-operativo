<?php
require('../../../../../app/help.php');

$idBaja = $_GET['idBaja'];
$idEstacion = $_GET['idEstacion'];

$datosUsuario = $ClassRecursosHumanosGeneral->PersonalBajaDetalle($idBaja);
$proceso = $datosUsuario['proceso'];
$EstadoProceso = $datosUsuario['estado_proceso'];

if($EstadoProceso == 0){
$estado = "Pendiente";
}else if($EstadoProceso == 1){
$estado = "En Proceso";
}else if($EstadoProceso == 2){
$estado = "Finalizado";
}

?>

<div class="modal-header">
<h5 class="modal-title">Editar proceso de baja</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

<button type="button" class="btn btn-labeled2 btn-success" onclick="EditarProcesoPersonal(<?=$idBaja?>,<?=$idEstacion?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button> 

</div>

 