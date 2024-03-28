 <?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


?>
 
 
 <div class="modal-header">
  <h5 class="modal-title">Agregar Incidencia <?=$estacion?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">


<h6 class="mb-1">Fecha:</h6>
<input class="form-control" type="date" id="FechaInc">

<h6 class="mb-1 mt-2">Hora:</h6>
<input class="form-control" type="time" id="HoraInc">

<h6 class="mb-1 mt-2">Incidente:</h6>
<input class="form-control" type="text" id="IncidenciaInc">

<h6 class="mb-1 mt-2">Responsable:</h6>
<input class="form-control" type="text" id="ResponsableInc">

<h6 class="mb-1 mt-2">Asunto:</h6>
<input class="form-control" type="text" id="AsuntoInc">

<h6 class="mb-1 mt-2">Comentarios:</h6>
<textarea class="form-control" id="ComentariosInc"></textarea>

<h6 class="mb-1 mt-2">Archivo:</h6>
<input class="form-control" type="file" id="DocumentoInc">

</div>


<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="GuardarIncidencia(<?=$idEstacion;?>)">Guardar</button>
</div>