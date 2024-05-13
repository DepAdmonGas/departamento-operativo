<?php
require ('../../../../../help.php');

$idReporte = $_GET['idReporte'];
$empresa = $_GET['empresa'];

$sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '" . $idReporte . "' AND empresa = '" . $empresa . "' ";
$result_listacierre = mysqli_query($con, $sql_listacierre);
$TotalImporte = 0;
$TotalTicket = 0;
while ($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)) {

    $TotalImporte = $TotalImporte + $row_listacierre['importe'];
    $TotalTicket = $TotalTicket + $row_listacierre['ticktes'];
}
?>
<td class="align-middle text-center">Total</td>
<td class="align-middle text-end"><b><?= number_format($TotalImporte, 2); ?></b></td>
<td class="align-middle text-center"><b><?= $TotalTicket; ?></b></td>
<td></td>