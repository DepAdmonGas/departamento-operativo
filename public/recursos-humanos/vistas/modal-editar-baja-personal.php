<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idPersonal = $_GET['idPersonal'];

$sql = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.estado,
op_rh_puestos.puesto
FROM op_rh_personal 
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre_completo'];
}

function Formato($idPersonal, $con){

$sql = "SELECT * FROM op_rh_personal_baja WHERE id_personal = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha = $row['fecha'];
$causa = $row['causa'];
$motivo = $row['motivo'];
$archivo = $row['archivo'];
}

$array = array('fecha' => $fecha, 
  'causa' => $causa, 
  'motivo' => $motivo,
  'archivo' => $archivo);
}else{

$array = array('fecha' => '', 'causa' => '', 'archivo' => '');
}
return $array;
}

$Formato = Formato($idPersonal,$con);

?>
<div class="modal-header">
<h5 class="modal-title">Editar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="mb-2" style="font-size: 1.2em"><?=$nombre;?></div>

<small class="text-secondary fs-6 fw-bold">Fecha baja:</small>
<input type="date" id="Fecha" class="form-control mt-2" value="<?=$Formato['fecha'];?>">

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Causa:</small></div>
<textarea class="form-control mt-2" id="Causa"><?=$Formato['causa'];?></textarea>

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Motivo:</small></div>
<textarea class="form-control mt-2" id="Motivo"><?=$Formato['motivo'];?></textarea>

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Archivo:</small></div>
<input type="file" class="mt-2" id="Archivo">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>,<?=$idPersonal;?>)">Guardar</button>
</div>
