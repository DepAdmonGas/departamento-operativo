<?php
require ('../../../../../help.php');

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

<th colspan="2" class="bg-white text-center">Total producto:</th>
<td class="bg-white align-middle text-center"><strong><?= $totalCantidad; ?></strong></td>
<th class="bg-white align-middle text-center">Total importe:</th>
<td class="bg-white align-middle text-end"><strong><?= number_format($totalPrecio, 2); ?></strong></td>