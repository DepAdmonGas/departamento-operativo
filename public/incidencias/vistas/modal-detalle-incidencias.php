<?php
require('../../../app/help.php');

$id = $_GET['id'];

$sql = "SELECT * FROM op_incidencias WHERE id = '".$id."' ";  
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$fecha = FormatoFecha($row['fecha']);
$asunto = $row['asunto'];
$responsable = $row['responsable'];
$tiempo_actividad = $row['tiempo_actividad'];
$archivo = $row['archivo'];



if($archivo  != ""){

$pdfInput = '<iframe class="border-0 mt-1" src="../../../archivos/incidencias/'.$archivo.'" width="100%" height="400px">
  </iframe>';
}else{
$pdfInput = 'S/I';
}

}

?>

<div class="modal-header">
<h5 class="modal-title">Detalle incidencias</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<div class="modal-body">

<h6 class="mb-1">Fecha:</h6>
<label><?=$fecha;?></label>

<h6 class="mt-3 mb-1">Asunto:</h6>
<label><?=$asunto;?></label>

<h6 class="mt-3 mb-1">Responsable:</h6>
<label><?=$responsable;?></label>

<h6 class="mt-3 mb-1">Tiempo que duro la actividad:</h6>
<label><?=$tiempo_actividad;?></label>

<h6 class="mt-3 mb-1">Anexo/Evidencia:</h6>
<?=$pdfInput;?>
</div>

</div>
 