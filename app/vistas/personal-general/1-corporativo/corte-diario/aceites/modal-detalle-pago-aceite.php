<?php
require ('../../../../../help.php');

$idaceite = $_GET['idaceite'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$result = $corteDiarioGeneral->modalDetallePagoAceite($idaceite);

$sql_reporte = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id = '" . $idaceite . "' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
  $concepto = $row_reporte['concepto'];
  $inventario_bodega = $corteDiarioGeneral->valRow($row_reporte['inventario_bodega']);
  $inventario_exibidores = $corteDiarioGeneral->valRow($row_reporte['inventario_exibidores']);
  $bodega = $corteDiarioGeneral->valRow($row_reporte['bodega']);
  $exibidores = $corteDiarioGeneral->valRow($row_reporte['exibidores']);
  $pedido = $corteDiarioGeneral->valRow($row_reporte['pedido']);
  $noaceite = $row_reporte['id_aceite'];
  $IdReporte = $row_reporte['id_mes'];
  $totalaceites = $corteDiarioGeneral->totalAceites($IdReporte, $noaceite);
  $inventarioI = $bodega + $exibidores;
  $inventarioF = $inventarioI + $pedido - $totalaceites;
  $inventario_final = $inventario_bodega + $inventario_exibidores;
  $diferencia = $inventario_final - $inventarioF;
}
?>
<div class="modal-header">
  <h5 class="modal-title">Detalle pago de diferencia</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <?= $ClassHerramientasDptoOperativo->FormatoFecha($result[0]); ?></br>
  Se pago la cantidad de <b><?= abs($diferencia); ?>pzs</b>, del siguiente aceite o lubricante</br>
  <b><?= $concepto; ?></b>
  <hr>

  <div class="mt-2 mb-1"><small>Ficha de pago</small></div>
  <a href="../../archivos/<?= $result[2]; ?>" download><img class="pr-2" src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></a>

  <div class="mt-2 mb-1"><small>Comentario</small></div>
  <div class="p-2 border">
    <?php
    if ($result[1] != "") {
      echo $result[1];
    } else {
      echo "S/C";
    }
    ?>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-primary"
    onclick="PagarDiferencia(<?= $idaceite; ?>,<?= $year ?>,<?= $mes; ?>)">Pagar</button>
</div>