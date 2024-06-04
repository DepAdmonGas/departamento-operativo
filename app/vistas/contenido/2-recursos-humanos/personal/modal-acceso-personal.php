<?php 
require('../../../../../app/help.php');
 
$idPersonal = $_GET['idPersonal'];
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idPersonal);
$NombreCompleto = $datosUsuario['nombre_personal'];
$ClassRecursosHumanosGeneral->AgregarAcceso($idPersonal);

$sql_acceso = "SELECT * FROM op_rh_personal_acceso WHERE id_personal = '".$idPersonal."' LIMIT 1 ";
$result_acceso = mysqli_query($con, $sql_acceso);
$numero_acceso = mysqli_num_rows($result_acceso);

while($row_acceso = mysqli_fetch_array($result_acceso, MYSQLI_ASSOC)){
$huella = $row_acceso['huella'];	
$pin = $row_acceso['pin'];

if($huella != ""){

$huellaAcceso = '<div class="text-center mt-4"><img src="'.RUTA_IMG_ICONOS.'huella-si.png"></div>
<div class="text-center fw-lighter fs-5 mt-4"><small><b>Sí</b> cuenta con una huella digital registrada en la base de datos.</small></div>';

}else{

$huellaAcceso = '<div class="text-center mt-4">
<img src="'.RUTA_IMG_ICONOS.'huella-no.png"></div>
<div class="text-center fw-lighter fs-5 mt-4">
<small>"<b>No</b> cuenta con una huella digital registrada en la base de datos."</small>
</div>';

}

if($pin != 0){

$pinAcceso = '
<div class="text-center mt-4"><img src="'.RUTA_IMG_ICONOS.'llave-si.png"></div>
<div class="text-center fw-lighter fs-5 mt-4">
<div class="row">

<div class="col-10 text-start"> <small>"<b>Si</b> cuenta con PIN registrado en la base de datos."</small> </div>
<div class="col-2"> <img class="pointer float-end mt-2" width="24px" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarPin()"> </div>
</div>


</div>

<div class="text-center fw-lighter fs-4 mt-2"><strong>PIN: '.$pin.'</strong></div>
<div id="inputEditar" style="display:none">
<div class="input-group mt-3">
<input type="number" class="form-control rounded-0" placeholder="Agregar PIN" min="1" id="PinAcceso">
<button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="EditPin('.$idPersonal.')"><small>Editar PIN</small></button>
</div>
</div>';

}else{

$pinAcceso = '
<div class="text-center mt-4"><img src="'.RUTA_IMG_ICONOS.'llave-no.png"></div>
<div class="text-center fw-lighter fs-5 mt-4">
<small>"<b>No</b> cuenta con PIN registrado en la base de datos."</small>
</div>

<div class="input-group mt-3">
<input type="number" class="form-control rounded-0" placeholder="Agregar PIN" min="1" id="PinAcceso">
<button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="EditPin('.$idPersonal.')"><small>Agregar PIN</small></button>
</div>';

}

}

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarPin = "d-none";

}else{
$ocultarPin = "";
}

 

?>

<div class="modal-header">
<h5 class="modal-title">Acceso - <?=$NombreCompleto?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button></div>

<div class="modal-body">

<div class="row mt-1 justify-content-md-center">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
<div class="border p-3">
<div class="fs-4 fw-lighter text-center"><strong>Huella digital</strong></div>
<?=$huellaAcceso;?>
</div>
</div>


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 <?=$ocultarPin?>">
<div class="border p-4">				
<div class="fs-4 fw-lighter text-center"><strong>PIN</strong></div>
<?=$pinAcceso?>
<div id="Resultado"></div>
</div>
</div>



</div>

</div>
</div>
</div>

