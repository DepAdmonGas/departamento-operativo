<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$depu = $_GET['depu'];
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

    <b class=""><?=$estacion;?></b>
    
    <div class="mb-2 mt-2">
    <div class="text-secondary mb-1">* Factura telcel:</div>
    <input class="form-control" type="file" id="Factura">
    </div>

    <div class="">
    <div class="text-secondary mb-1">* Comprobante de pago:</div>
    <input class="form-control" type="file" id="Pago">
    </div>


  </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="CancelarTelcel(<?=$idEstacion;?>,<?=$depu;?>,<?=$year;?>,<?=$mes;?>)">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="EditarTelcelInfo(<?=$idEstacion;?>,<?=$depu;?>,<?=$year;?>,<?=$mes;?>,<?=$id;?>)">Editar</button>
      </div>


