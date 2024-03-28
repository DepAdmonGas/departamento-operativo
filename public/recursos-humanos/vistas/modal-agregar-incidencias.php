<?php
require ('../../../app/help.php');
$idAsistencia = $_GET['idAsistencia'];
$idPersonal = $_GET['idPersonal'];
$idEstacion = $_GET['idEstacion'];

$sql_personal = "SELECT 
op_rh_personal.id,
op_rh_personal.nombre_completo,
op_rh_puestos.puesto
FROM op_rh_personal
INNER JOIN op_rh_puestos
ON op_rh_personal.id_puesto = op_rh_puestos.id 
WHERE op_rh_personal.id = '".$idPersonal."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$puesto = $row_personal['puesto'];
}

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

$sql_incidencia = "SELECT fecha, incidencia FROM op_rh_personal_asistencia WHERE id = '".$idAsistencia."' ";
$result_incidencia = mysqli_query($con, $sql_incidencia);
$numero_incidencia = mysqli_num_rows($result_incidencia);
while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
$fecha = $row_incidencia['fecha'];
$puntos = $row_incidencia['incidencia'];
}

$return = array (
"fechaAcceso" => $fecha,
"puntosAcceso" => $puntos
); 

return $return;
}

$incidencia = Incidencia($idAsistencia, $con);
$PuntosIncidencias = PuntosIncidencias($idAsistencia, $con);

?>
<div class="modal-header">
<h5 class="modal-title">Incidencia</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<?php
if($incidencia['resultado'] == 0){
?>

<p class="fs-6 fw-light">Seleccione alguna de las siguientes incidencias:</p>

<div id="bordercheck" class="p-2 mt-0 mb-0">
<?php
$sql_incidencia = "SELECT * FROM op_rh_lista_incidencias ";
$result_incidencia = mysqli_query($con, $sql_incidencia);
$numero_incidencia = mysqli_num_rows($result_incidencia);
while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
$id = $row_incidencia['id'];
$detalle = $row_incidencia['detalle'];

if($puesto == "Gerente" AND $id == 5){

}else{
?>
<div class="form-check">
  <input class="form-check-input fs-5 fw-light" type="radio" name="CheckBox" id="Incidencia<?=$id;?>" value="<?=$id;?>">
  <label class="form-check-label fs-5 fw-light" for="Incidencia<?=$id;?>">
    <b><?=$detalle;?></b>
  </label>
</div>
<?php  
}


}
?>
</div>


<p class="fs-6 fw-light mt-2">Comentario:</p>
<textarea class="form-control" id="Comentario"></textarea>


<div class="mt-3 pt-3 text-end border-top">
<button type="button" class="btn btn-primary rounded-0 fw-lighter fs-6" onclick="GuardarIncidencia(<?=$idAsistencia;?>,<?=$idEstacion;?>)">Guardar incidencia</button>
</div>


<?php
}else{
$explode = explode(" ", $incidencia['fecha']);
?>

<small class="text-secondary fs-6 fw-bold">Fecha:</small>
<div class="fs-5 fw-light border-0 p-0 mb-3"><?=FormatoFecha($explode[0])?></div>

<small class="text-secondary fs-6 fw-bold">Incidencia:</small>
<div class="fs-5 fw-light border-0 p-0 mb-3"><?=$incidencia['incidencia']?></div>

<small class="text-secondary fs-6 fw-bold">Comentario:</small>
<div class="fs-5 fw-light border-0 p-0 mb-3"><?=$incidencia['comentario']?></div>


<?php
if ($incidencia['incidencia'] == "Turno y medio con retardo"){

echo '<hr><small>Sueldo día:</small>
      <input type="number" class="form-control mt-1" id="SueldoDiaTMR" step="0.01" value="'.$PuntosIncidencias['puntosAcceso'].'" />

      <div class="text-end mt-2">
      <button type="button" class="btn btn-success mt-2" onclick="EditarSaldoTMR('.$idAsistencia.')">Guardar</button>
      </div>';
}

if ($incidencia['incidencia'] == "Incapacidad" || $incidencia['incidencia'] == "Incapacidad IMSS" || $incidencia['incidencia'] == "Maternidad" && $incidencia['documento'] == ""){

if ($incidencia['documento'] == ""){
echo '<hr><small class="text-secondary fs-6 fw-bold">Documento:</small>
      <input type="file" class="form-control mt-1" id="Documento">

      <div class="mt-2"><small class="text-secondary fs-6 fw-bold">Fecha de inicio y termino de la incapacidad:</small></div>

      <small>Fecha Inicio:</small>
      <input type="date" value="'.$PuntosIncidencias['fechaAcceso'].'" class="form-control mt-1" id="FechaIni" />

      <small>Fecha Fin:</small>
      <input type="date" class="form-control mt-1" value="'.$PuntosIncidencias['fechaAcceso'].'" id="FechaFin" />

      <small>Sueldo día:</small>
      <input type="number" class="form-control mt-1" id="SueldoDiaI" step="0.01" value="'.$PuntosIncidencias['puntosAcceso'].'" />

      <div class="text-end mt-2">
      <button type="button" class="btn btn-success btn-sm" onclick="GuardarDoc('.$idPersonal.','.$idAsistencia.','.$idEstacion.')">Guardar</button>
      </div>';
}else{
echo '<hr><small class="text-secondary fs-6 fw-bold">Documento:</small>
      <a href="archivos/incidencias/'.$incidencia['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" ></a>';

}

}

}
?>

<div id="Resultado"></div>
</div>


