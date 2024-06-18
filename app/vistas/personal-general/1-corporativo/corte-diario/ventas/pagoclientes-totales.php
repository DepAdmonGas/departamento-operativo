<?php
require ('../../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_listaclientes = "SELECT importe FROM op_pago_clientes WHERE idreporte_dia = '" . $idReporte . "' ";
$result_listaclientes = mysqli_query($con, $sql_listaclientes);
$totalImporte = 0;
while ($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)) {
    $importe = $row_listaclientes['importe'];
    $totalImporte = $totalImporte + $importe;
}
?>
<th class="bg-white text-center">TOTAL 4</th>
<td class="bg-white align-middle text-end"><strong><?= number_format($totalImporte, 2); ?></strong></td>
<td class="bg-white align-middle text-end"></td>