 <?php
require('../../../app/help.php');

$idaceite = $_GET['idaceite'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_reporte = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id = '".$idaceite."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);
    while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
    $concepto = $row_reporte['concepto'];
    $inventario_bodega = $row_reporte['inventario_bodega'];
    $inventario_exibidores = $row_reporte['inventario_exibidores'];
    $bodega = $row_reporte['bodega'];
    $exibidores =$row_reporte['exibidores'];
    $pedido = $row_reporte['pedido'];
    $noaceite = $row_reporte['id_aceite'];
    $IdReporte = $row_reporte['id_mes'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);

    $inventarioI = $bodega + $exibidores;
    $inventarioF = $inventarioI + $pedido - $totalaceites;

    $inventario_final = $inventario_bodega + $inventario_exibidores;
    $diferencia = $inventario_final - $inventarioF;
    }

    function valRow($valor){

    if ($valor == 0) {
        $resultado = "";
      }else{
        $resultado =  number_format($valor, 2, '.', '');
      }

      return $resultado;

  }

      function totalaceites($IdReporte,$noaceite, $con){

    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    $cantidad = 0;
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];

       $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];


    }

    }

    return $cantidad;

    }
?>

 <div class="modal-header">
        <h5 class="modal-title">Pago de diferencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

 <div class="modal-body">

 	   <div class="alert alert-secondary" role="alert">
  Solo cuentas con 5 días para realizar el pago de diferencias.
</div>

 	Se debe pagar la cantidad de <b><?=abs($diferencia);?>pzs</b>, del siguiente aceite o lubricante</br>
 	<b><?=$concepto;?></b>
  <hr>
 <div class="mt-2 mb-1"><small>* Selecciona el documento de pago (PDF)</small></div>
<input class="form-control" type="file" id="Documento">

<div class="mt-2 mb-1"><small>* Comentario</small></div>
<textarea class="form-control" id="Comentario"></textarea>
       
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="PagarDiferencia(<?=$idaceite;?>,<?=$year?>,<?=$mes;?>)">Pagar</button>
 </div>