 <?php
require('../../../app/help.php');
$idIncidencia = $_GET['idIncidencia'];

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
$pdfInput = '<iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.'incidencias/'.$archivo.'" width="100%" height="450px">
  </iframe>';

}else{
$pdfInput = 'S/I';
}


?>
 
 
 <div class="modal-header">
  <h5 class="modal-title">Detalle Incidencia</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<div class="row">

<div class="col-12 mb-3">
<h6 class="mb-1">Fecha y hora:</h6>
<label><?=$fecha?>, <?=$hora?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-1">Incidente:</h6>
<label><?=$incidente?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-1">Responsable:</h6>
<label><?=$responsable?></label>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-1">Asunto:</h6>
<label><?=$asunto?></label>
</div>

<div class="col-12 mb-3">
<h6 class="mb-1">Comentarios:</h6>
<label><?=$comentarios?></label>
</div>

<div class="col-12 mb-3">
<h6 class="mb-1">Archivo:</h6>
<?=$pdfInput?> 
</div>

</div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa fa-xmark"></i></span>Cerrar</button>
</div>