 <?php
require('../../../app/help.php');
$idIncidencia = $_GET['idIncidencia'];

$sql_lista = "SELECT * FROM op_incidencias_estaciones WHERE id_incidencias_estaciones = '".$idIncidencia."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id_estacion = $row_lista['id_estacion'];
$fecha = $row_lista['fecha'];
$hora = $row_lista['hora'];
$incidente = $row_lista['incidente'];
$responsable = $row_lista['responsable'];
$asunto = $row_lista['asunto'];
$comentarios = $row_lista['comentarios'];
$archivo = $row_lista['archivo'];
}

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


?> 
 
 
 <div class="modal-header">
  <h5 class="modal-title">Editar Incidencia (<?=$estacion?>)</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">


<h6 class="mb-1">Fecha:</h6>
<input class="form-control" type="date" id="FechaInc" value="<?=$fecha?>">

<h6 class="mb-1 mt-2">Hora:</h6>
<input class="form-control" type="time" id="HoraInc" value="<?=$hora?>">

<h6 class="mb-1 mt-2">Incidente:</h6>
<input class="form-control" type="text" id="IncidenciaInc" value="<?=$hora?>">

<h6 class="mb-1 mt-2">Responsable:</h6>
<input class="form-control" type="text" id="ResponsableInc" value="<?=$responsable?>">

<h6 class="mb-1 mt-2">Asunto:</h6>
<input class="form-control" type="text" id="AsuntoInc" value="<?=$asunto?>">

<h6 class="mb-1 mt-2">Comentarios:</h6>
<textarea class="form-control" id="ComentariosInc"><?=$comentarios?></textarea>

<h6 class="mb-1 mt-2">Archivo:</h6>
<input class="form-control" type="file" id="DocumentoInc">

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="EditarIncidencia(<?=$idIncidencia;?>,<?=$id_estacion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>