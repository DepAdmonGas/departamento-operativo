<?php
require('../../../app/help.php');

$idPersonal = $_GET['idPersonal'];

AgregarAcceso($idPersonal,$con);
function AgregarAcceso($idPersonal,$con){
$sql_val = "SELECT * FROM op_rh_personal_acceso WHERE id_personal = '".$idPersonal."' ";
$result_val = mysqli_query($con, $sql_val);
$numero_val = mysqli_num_rows($result_val);	
if($numero_val == 0){

$sql_agregar_horario = "INSERT INTO op_rh_personal_acceso
(
id_personal,
huella,
pin
) 

VALUES 

(
'".$idPersonal."',
'',
0
) 
";

if(mysqli_query($con, $sql_agregar_horario)){
$result = true;
}else{
$result = false;
}

}
return $result;
}
 
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$idPersonal."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$NombreCompleto = $row_personal['nombre_completo'];
$Documento = $row_personal['documentos'];
}

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
<small>"<b>Si</b> cuenta con PIN registrado en la base de datos."</small>
<div class="float-right"><img class="pointer" width="18px" src="'.RUTA_IMG_ICONOS.'editar.png" onclick="EditarPin()"></div>
</div>

<div class="text-center fw-lighter fs-4 mt-2"><strong>PIN: '.$pin.'</strong></div>

<div id="inputEditar" style="display:none">
<div class="input-group mt-3">
  <input type="number" class="form-control rounded-0" placeholder="Agregar PIN" min="1" id="PinAcceso">
  <button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="EditPin('.$idPersonal.')"><small>Editar PIN</small></button>
</div></div>';

}else{

$pinAcceso = '
<div class="text-center mt-4"><img src="'.RUTA_IMG_ICONOS.'llave-no.png"></div>
<div class="text-center fw-lighter fs-5 mt-4">
<small>"<b>No</b> cuenta con PIN registrado en la base de datos."</small>
</div>

<div class="input-group mt-3">
  <input type="number" class="form-control rounded-0" placeholder="Agregar PIN" min="1" id="PinAcceso">
  <button class="btn btn-outline-primary rounded-0 btn-sm" type="button" onclick="EditPin('.$idPersonal.')"><small>Agregar PIN</small></button>
</div>
';

}

}
?>

<div class="modal-header">
<h5 class="modal-title">Acceso</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row mt-1 justify-content-md-center">
		<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
			<div class="border p-4">
<h5><?=$NombreCompleto;?></h5>

<hr>


				<div class="fs-4 fw-lighter text-center"><strong>Huella digital</strong></div>

				<?=$huellaAcceso;?>

			</div>
		</div>
		<!--
		<div class="col-12 col-sm-6 col-md-6">
			<div class="border p-4">				
				<div class="fs-4 fw-lighter text-center"><strong>PIN</strong></div>
				<?=$pinAcceso;?>
				<div id="Resultado"></div>
			</div>
		</div>
	-->
	
	</div>

</div>
</div>
</div>

