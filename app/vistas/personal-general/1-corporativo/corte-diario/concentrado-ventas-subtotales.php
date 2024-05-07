<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idReporte . "' ";
$result_listayear = mysqli_query($con, $sql_listayear);
$SubTLitros = 0;
$SubJarras = 0;
$SubTotalLitros = 0;
$SubImporteTotal = 0;
while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

    $idventas = $row_listayear['id'];
    $producto = $row_listayear['producto'];
    $litrosventas = $row_listayear['litros'];
    $jarrasventas = $row_listayear['jarras'];
    $precio_litroventas = $row_listayear['precio_litro'];

    $litros = 0;
    $jarras = 0;
    $preciolitro = 0;

    if ($litrosventas != 0) {
        $litros = $litrosventas;
    }
    if ($jarrasventas != 0) {
        $jarras = $jarrasventas;
    }
    if ($precio_litroventas != 0) {

        $preciolitro = $precio_litroventas;
    }

    $totalLitros = $litrosventas - $jarrasventas;
    $importeTotal = $totalLitros * $precio_litroventas;

    $SubTLitros = $SubTLitros + $litros;
    $SubJarras = $SubJarras + $jarras;
    $SubTotalLitros = $SubTotalLitros + $totalLitros;
    $SubImporteTotal = $SubImporteTotal + $importeTotal;
}
?>
<td>A SUB-TOTAL (1+2+3)</td>
<td class="bg-light align-middle text-end" id="importetotal-<?= $idventas; ?>">
    <strong><?= number_format($SubTLitros, 2); ?></strong></td>
<td class="bg-light align-middle text-end" id="importetotal-<?= $idventas; ?>">
    <strong><?= number_format($SubJarras, 2); ?></strong></td>
<td class="bg-light align-middle text-end" id="importetotal-<?= $idventas; ?>">
    <strong><?= number_format($SubTotalLitros, 2); ?></strong></td>
<td class="bg-light"></td>
<td class="bg-light align-middle text-end" id="importetotal-<?= $idventas; ?>">
    <strong><?= number_format($SubImporteTotal, 2); ?></strong></td>