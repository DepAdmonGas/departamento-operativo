<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idCategoria = $_GET['idCategoria'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$id = $_GET['id'];

$sql = "SELECT * FROM op_incidencias WHERE id = '".$id."' ";  
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha = $row['fecha'];
$asunto = $row['asunto'];
$responsable = $row['responsable'];
$tiempo_actividad = $row['tiempo_actividad'];
$archivo = $row['archivo'];
}

if($id == 0){
$nameModal = "Agregar";
$BTN = 'Guardar';
$fechaInput = '<input class="form-control" type="date" id="fechaInc">';
$AsuntoInput = '<textarea class="form-control rounded-0" id="asuntoInc"></textarea>';
$responsableInput = '<input class="form-control" type="text" id="responsableInc">';
$actividadInput = '<input type="text" class="without_ampm form-control" id="tiempoInc">';
$pdfInput= '<input class="form-control" type="file" id="PDF">';

}else{
$nameModal = "Editar";
$BTN = 'Editar';
$fechaInput = '<input class="form-control" type="date" id="fechaInc" value="'.$fecha.'">';
$AsuntoInput = '<textarea class="form-control rounded-0" id="asuntoInc">'.$asunto.'</textarea>';
$responsableInput = '<input class="form-control" type="text" id="responsableInc" value="'.$responsable .'">';
$actividadInput = '<input type="text" class="without_ampm form-control" id="tiempoInc" value="'.$tiempo_actividad .'"> ';
$pdfInput = '<input class="form-control" type="file" id="PDF" value="'.$archivo.'">';	

}
?> 


<div class="modal-header">
<h5 class="modal-title"><?=$nameModal?> incidencia</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body"> 

<h6 class="mb-1">Fecha:</h6>
<?=$fechaInput;?>

<h6 class="mt-3 mb-1">Asunto:</h6>
<?=$AsuntoInput;?>

<h6 class="mt-3 mb-1">Responsable:</h6>
<?=$responsableInput;?>

<h6 class="mt-3 mb-1">Tiempo que duro la actividad:</h6>
<?=$actividadInput;?>


<h6 class="mt-3 mb-1">PDF:</h6>
<?=$pdfInput;?>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>,<?=$idCategoria;?>,<?=$year;?>,<?=$mes;?>,<?=$id;?>)"><?=$BTN;?></button>
</div>