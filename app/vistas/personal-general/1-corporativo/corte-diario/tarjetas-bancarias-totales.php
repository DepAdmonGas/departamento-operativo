<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' ";
$result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
$baucherTotal = 0;
while ($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)) :
    $baucherTotal = $baucherTotal + $row_listatarjetas['baucher'];
endwhile;
?>
<th class="bg-light text-center" colspan="2">TOTAL 2</th>
<td class="bg-light align-middle text-end"><strong><?= number_format($baucherTotal, 2); ?></strong></td>