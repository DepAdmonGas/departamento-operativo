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
  <h5 class="modal-title">Agregar (en caso de incidencias)</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<h6 class="mb-1 text-secondary fw-bold">* FECHA:</h6>
<input class="form-control" type="date" id="FechaP">

<h6 class="mb-1 mt-3 text-secondary fw-bold">* HORA:</h6>
<input class="form-control" type="time" id="HoraP">

<h6 class="mb-1 mt-3 text-secondary fw-bold">* ASUNTO:</h6>
<input class="form-control" id="AsuntoP">

<h6 class="mt-3 mb-1 text-secondary fw-bold">* OBSERVACIONES:</h6>
<textarea class="form-control" id="ObservacionesP"></textarea>

<h6 class="mt-3 mb-1 text-secondary fw-bold">* SOLUCIÓN/RESULTADOS FINALES:</h6>
<textarea class="form-control" id="SolucionP"></textarea>

<h6 class="mt-3 mb-1 text-secondary fw-bold">* EVIDENCIA:</h6>
<input class="form-control" type="file" id="EvidenciaP">

</div>


<div class="modal-footer">
    
<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarIncidenciaP(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
  