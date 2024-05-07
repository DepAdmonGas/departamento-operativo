<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $idReporte . "' ";
$result_listaaceites = mysqli_query($con, $sql_listaaceites);
$totalCantidad = 0;
$totalPrecio = 0;
while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

    $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];

    $totalCantidad = $totalCantidad + $row_listaaceites['cantidad'];
    $totalPrecio = $totalPrecio + $importe;
}

?>

<td class="bg-light text-center"></td>
<td class="bg-light text-center"></td>
<td class="bg-light align-middle text-center"><strong><?= $totalCantidad; ?></strong></td>
<td class="bg-light align-middle text-end"></td>
<td class="bg-light align-middle text-end"><strong><?= number_format($totalPrecio, 2); ?></strong></td>