 <?php
require('../../../app/help.php');
$idIncidencia = $_GET['idIncidencia'];


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


$sql_lista = "SELECT * FROM op_incidencias_estaciones WHERE id_incidencias_estaciones = '".$idIncidencia."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$fecha = FormatoFecha($row_lista['fecha']);
$hora = date("g:i a",strtotime($row_lista['hora']));
$incidente = $row_lista['incidente'];
$responsable = $row_lista['responsable'];
$asunto = $row_lista['asunto'];
$comentarios = $row_lista['comentarios'];
$archivo = $row_lista['archivo'];
}
 

if($archivo  != ""){
$pdfInput = '<iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.'incidencias/'.$archivo.'" width="100%" height="400px">
  </iframe>';

}else{
$pdfInput = 'S/I';
}


?>
 
 
 <div class="modal-header">
  <h5 class="modal-title">Detalle Incidencia <?=$estacion?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">


<h6 class="mb-1">Fecha:</h6>
<label><?=$fecha?></label>

<h6 class="mb-1 mt-2">Hora:</h6>
<label><?=$hora?></label>

<h6 class="mb-1 mt-2">Incidente:</h6>
<label><?=$incidente?></label>

<h6 class="mb-1 mt-2">Responsable:</h6>
<label><?=$responsable?></label>

<h6 class="mb-1 mt-2">Asunto:</h6>
<label><?=$asunto?></label>

<h6 class="mb-1 mt-2">Comentarios:</h6>
<label><?=$comentarios?></label>

<h6 class="mb-1 mt-2">Archivo:</h6>
<?=$pdfInput?> 

</div>


<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>