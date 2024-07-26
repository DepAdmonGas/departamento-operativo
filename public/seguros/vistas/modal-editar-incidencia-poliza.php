<?php
require('../../../app/help.php');

$idPolizaInc = $_GET['idPolizaInc'];

$sql_lista_poliza = "SELECT * FROM op_poliza_incidencia WHERE id_poliza_incidencia = '".$idPolizaInc ."'";
$result_lista_poliza = mysqli_query($con, $sql_lista_poliza);
$numero_lista_poliza = mysqli_num_rows($result_lista_poliza);

while($row_lista_poliza = mysqli_fetch_array($result_lista_poliza, MYSQLI_ASSOC)){
    $GET_idEstacion = $row_lista_poliza['id_estacion'];
    $fechaIn = $row_lista_poliza['fecha'];
    $horaIn = $row_lista_poliza['hora'];
    $asunto = $row_lista_poliza['asunto'];
    $observaciones = $row_lista_poliza['observaciones'];
    $solucion = $row_lista_poliza['solucion'];
    $archivo = $row_lista_poliza['archivo'];
}


if($archivo  != ""){
$pdfInput = '<iframe class="border-0 mt-1" src="archivos/incidencias-poliza-es/'.$archivo.'" width="100%" height="400px">
  </iframe>';

}else{
$pdfInput = 'S/I';
}

 

?>

 <div class="modal-header">
  <h5 class="modal-title">Editar (en caso de incidencias)</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<h6 class="mb-1">Fecha:</h6>
<input class="form-control" type="date" id="FechaP" value="<?=$fechaIn?>">

<h6 class="mb-1 mt-3">Hora:</h6>
<input class="form-control" type="time" id="HoraP" value="<?=$horaIn?>">

<h6 class="mb-1 mt-3">Asunto:</h6>
<input class="form-control"  id="AsuntoP" value="<?=$asunto?>">

<h6 class="mt-3 mb-1">Observaciones:</h6>
<textarea class="form-control" id="ObservacionesP"><?=$asunto?></textarea>

<h6 class="mt-3 mb-1">Solución/Resultados finales:</h6>
<textarea class="form-control" id="SolucionP"><?=$solucion?></textarea>

<h6 class="mt-3 mb-1">Evidencia:</h6>
<input class="form-control" type="file" id="EvidenciaP">


</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal"> <span class="btn-label2"><i class="fa fa-remove"></i></span>Cerrar</button>
<button type="button" class="btn btn-labeled2 btn-success" onclick="EditarIncidenciaP(<?=$idPolizaInc;?>,<?=$GET_idEstacion?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>


</div>
     