<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$totalImporte = $corteDiarioGeneral->getTotalImporte($idReporte);
$baucherTotal = $corteDiarioGeneral->getBaucherTotal($idReporte);
$consumo = $corteDiarioGeneral->getConsumoTotal($idReporte);

echo "<strong>" . number_format($totalImporte + $baucherTotal + $consumo, 2) . "</strong>";


//------------------
mysqli_close($con);
//------------------ 




