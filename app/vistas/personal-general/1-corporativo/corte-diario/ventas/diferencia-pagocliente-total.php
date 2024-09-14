<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$tabla = "clientes";
$totalImporte = $corteDiarioGeneral->getTotalImporte( $idReporte ,$tabla);
$pago = $corteDiarioGeneral->getPagoTotal($idReporte);
echo "<strong>$ " . number_format($pago - $totalImporte, 2) . "</strong>";