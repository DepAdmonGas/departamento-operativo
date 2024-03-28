<?php
require ('../../../app/help.php');
$idAsistencia = $_GET['idAsistencia'];

function Incidencia($idAsistencia, $con){

$sql_incidencia = "SELECT * FROM op_rh_personal_asistencia_incidencia WHERE id_asistencia = '".$idAsistencia."' LIMIT 1 ";
$result_incidencia = mysqli_query($con, $sql_incidencia);
$numero_incidencia = mysqli_num_rows($result_incidencia);
if ($numero_incidencia > 0) {
while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
$fecha = $row_incidencia['fecha'];  
$incidencia = $row_incidencia['incidencia']; 
$comentario = $row_incidencia['comentario']; 
$documento = $row_incidencia['documento'];  
$estado = $row_incidencia['estado'];
}

$return = array (
"fecha" => $fecha,
"incidencia" => $incidencia,
"comentario" => $comentario,
"documento" => $documento,
"estado" => $estado,
"resultado" => 1
); 

}else{

$return = array (
"fecha" => $fecha,
"incidencia" => $incidencia,
"comentario" => $comentario,
"documento" => $documento,
"estado" => $estado,   
"resultado" => 0 
); 

}

return $return;
}

function PuntosIncidencias($idAsistencia, $con){

$sql_incidencia = "SELECT incidencia FROM op_rh_personal_asistencia WHERE id = '".$idAsistencia."' ";
$result_incidencia = mysqli_query($con, $sql_incidencia);
$numero_incidencia = mysqli_num_rows($result_incidencia);
while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
$puntos = $row_incidencia['incidencia'];
}
return $puntos;
}

$incidencia = Incidencia($idAsistencia, $con);
$puntos = PuntosIncidencias($idAsistencia, $con);
?>
<div class="modal-header">
<h5 class="modal-title">Incidencia</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<?php
if($incidencia['resultado'] == 0){

echo '<div class="text-center fs-4 fw-light">No se encontró información de incidencias en el sistema</div>';

}else{
$explode = explode(" ", $incidencia['fecha']);
?>

<small class="text-secondary fw-bold">Fecha:</small>
<div class="fw-light border-0 mb-3"><?=FormatoFecha($explode[0])?></div>

<small class="text-secondary fw-bold">Incidencia:</small>
<div class="fw-light border-0 mb-3"><?=$incidencia['incidencia']?></div>

<small class="text-secondary fw-bold">Comentario:</small>
<div class="fw-light border-0 mb-3"><?=$incidencia['comentario']?></div>

<small class="text-secondary fw-bold">Sueldo día:</small>
<div class="fw-light border-0"><?=$puntos?></div>

<?php


if (($incidencia['incidencia'] == "Incapacidad" || $incidencia['incidencia'] == "Incapacidad IMSS" || $incidencia['incidencia'] == "Maternidad") && $incidencia['documento'] == ""){

echo '<hr><small class="text-secondary mt-3 fw-bold">Documento:</small>
      <input type="file" class="form-control" id="Documento">
      <div class="text-end mb-1">
      <button type="button" class="btn btn-success btn-sm" onclick="GuardarDoc('.$idAsistencia.')">Guardar</button>
      </div>';

if ($incidencia['documento'] != ""){
echo '<hr><small class="text-secondary fs-6 fw-bold">Documento:</small>
      <a href="../'.$incidencia['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" ></a>';
}
}

}
?>
</div>
