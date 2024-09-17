<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$totalImporte = $corteDiarioGeneral->getTotalImporte2( $idReporte );
$pago = $corteDiarioGeneral->getPagoTotal($idReporte);
echo "<strong>$ " . number_format($pago - $totalImporte, 2) . "</strong>";