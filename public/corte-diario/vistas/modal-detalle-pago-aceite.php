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
    $inventario_bodega = valRow($row_reporte['inventario_bodega']);
    $inventario_exibidores = valRow($row_reporte['inventario_exibidores']);
    $bodega = valRow($row_reporte['bodega']);
    $exibidores = valRow($row_reporte['exibidores']);
    $pedido = valRow($row_reporte['pedido']);
    $noaceite = $row_reporte['id_aceite'];
    $IdReporte = $row_reporte['id_mes'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);
    $inventarioI = $bodega + $exibidores;
    $inventarioF = $inventarioI + $pedido - $totalaceites;
    $inventario_final = $inventario_bodega + $inventario_exibidores;
    $diferencia = $inventario_final - $inventarioF;
    }
    $comentario = '';
    echo $sql_reporte_pago = "SELECT * FROM op_aceites_lubricantes_reporte_pagodiferencia WHERE id_aceite = '".$idaceite."' ";
   $result_reporte_pago = mysqli_query($con, $sql_reporte_pago);
   $numero_reporte_pago = mysqli_num_rows($result_reporte_pago);
    while($row_reporte_pago = mysqli_fetch_array($result_reporte_pago, MYSQLI_ASSOC)){

    $fechaHora = explode(' ', $row_reporte_pago['fecha']);
    $comentario = $row_reporte_pago['comentario'];
    $documento = $row_reporte_pago['documento'];

    }

    function valRow($valor){

    if ($valor == 0) {
        $resultado = 0;
      }else{
        $resultado =  number_format($valor, 2, '.', '');
      }

      return $resultado;

  }

      function totalaceites($IdReporte,$noaceite, $con){
        $cantidad =0;
    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
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
        <h5 class="modal-title">Detalle pago de diferencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

 <div class="modal-body">
  <?=FormatoFecha($fechaHora[0]);?></br>
 	Se pago la cantidad de <b><?=abs($diferencia);?>pzs</b>, del siguiente aceite o lubricante</br>
 	<b><?=$concepto;?></b>
  <hr>

 <div class="mt-2 mb-1"><small>Ficha de pago</small></div>
  <a  href="../../archivos/<?=$documento;?>" download><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>pdf.png"></a>

<div class="mt-2 mb-1"><small>Comentario</small></div>
<div class="p-2 border">
<?php
if ($comentario != "") {
echo $comentario;
}else{
echo "S/C"; 
}
?>
</div>  
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="PagarDiferencia(<?=$idaceite;?>,<?=$year?>,<?=$mes;?>)">Pagar</button>
 </div>