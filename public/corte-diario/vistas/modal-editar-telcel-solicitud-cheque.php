<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$id = $_GET['id'];

$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 

?>

 <div class="modal-header">
  <h5 class="modal-title">Facturas telcel, <?=nombremes($mes);?> del <?=$year;?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>

  <div class="modal-body">

    <b><?=$estacion;?></b>

    <div class="text-secondary mt-2">* Comprobante de pago:</div>
    <div class="mt-1">
    <input class="form-control" type="file" id="Pago">
    </div>

  </div>
  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="CancelarTelcel(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>)">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="EditarTelcelInfo(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$id;?>)">Editar</button>
      </div>


