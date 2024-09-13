<?php
require ('../../../../../help.php');

$idReporte = $_GET['idReporte'];
$tabla= "prosegur";
$totalImporte = $corteDiarioGeneral->getTotalImporte($idReporte,$tabla);
$baucherTotal = $corteDiarioGeneral->getBaucherTotal($idReporte);
$consumo = $corteDiarioGeneral->getConsumoTotal($idReporte);

echo "<strong>$ " . number_format($totalImporte + $baucherTotal + $consumo, 2) . "</strong>";

