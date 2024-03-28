<?php
require('../../../app/help.php');

$idPoliza = $_GET['idPoliza'];

$sql_lista_poliza = "SELECT * FROM op_poliza_es WHERE id_poliza = '".$idPoliza ."'";
$result_lista_poliza = mysqli_query($con, $sql_lista_poliza);
$numero_lista_poliza = mysqli_num_rows($result_lista_poliza);

while($row_lista_poliza = mysqli_fetch_array($result_lista_poliza, MYSQLI_ASSOC)){
    $idEstacion = $row_lista_poliza['id_estacion'];
    $emision = $row_lista_poliza['emision'];
    $vencimiento = $row_lista_poliza['vencimiento'];
}


?>


 <div class="modal-header">
  <h5 class="modal-title">Editar poliza</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>

 <div class="modal-body">

<h6 class="mb-1">Fecha de emisión:</h6>
<input class="form-control" type="date" id="EmisionP" value="<?=$emision?>" onchange="VencimientoPoliza()">

<h6 class="mb-1 mt-3">Fecha de vencimiento:</h6>
<div id="fechavencimiento" style="font-size: 1em"><input class="form-control" type="date" id="VencimientoP" value="<?=$vencimiento?>" ></div>


<h6 class="mt-3 mb-1">Documento:</h6>
<input class="form-control" type="file" id="PolizaDoc">

</div>

<div class="modal-footer">
<button type="button" class="btn btn-danger mt-3 float-end" onclick="RegresarPoliza(<?=$idEstacion;?>)">Cancelar</button>
<button type="button" class="btn btn-primary mt-3 float-end" onclick="EditarPolizaS(<?=$idPoliza;?>,<?=$idEstacion;?>)">Editar</button>
</div>