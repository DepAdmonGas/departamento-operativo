<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '" . $IdReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$SumGasolina = 0;
$SumRentas = 0;
$SumSodexo = 0;
$SumGTotal = 0;

$SumAutolavado = 0;
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $serie = $row_lista['serie'];

    if ($serie != "K" and $serie != "CP") {
        $total = $row_lista['total'];
    } else {
        $total = 0;
    }

    if ($serie != "RL" and $serie != "S" and $serie != "K" and $serie != "CP" and $serie != "CA") {
        $gasolina = $row_lista['total'];
    } else {
        $gasolina = 0;
    }

    if ($serie == "RL") {
        $rentas = $row_lista['total'];
    } else {
        $rentas = 0;
    }

    if ($serie == "S") {
        $sodexo = $row_lista['total'];
    } else {
        $sodexo = 0;
    }

    if ($serie == "AL") {
        $autolavado = $row_lista['total'];
    } else {
        $autolavado = 0;
    }


    $SumGasolina = $SumGasolina + $gasolina;
    $SumRentas = $SumRentas + $rentas;
    $SumSodexo = $SumSodexo + $sodexo;
    $SumGTotal = $SumGTotal + $total;

    $SumAutolavado = $SumAutolavado + $autolavado;
}


echo '<div class="col-12">
<div class="table-responsive">
<table class="custom-table mt-3" style="font-size: 12.5px;" width="100%">
<tbody class="bg-white">
<tr>
<th class="align-middle text-center no-hover">Subtotal Gasolina:</th>
<th class="align-middle text-center no-hover fw-normal">$ ' . number_format($SumGasolina, 2) . '</th>
</tr>

<tr>
<th class="align-middle text-center no-hover">Subtotal Rentas:</th>
<th class="align-middle text-center no-hover fw-normal">$ ' . number_format($SumGasolina, 2) . '</th>
</tr>';


if ($idEstacion == 2) {
    echo '<tr>
<th class="align-middle text-center no-hover">Subtotal Autolavado:</th>
<th class="align-middle text-center no-hover fw-normal">$ ' . number_format($SumAutolavado, 2) . '</th>
</tr>';
}

echo '<tr>
<th class="align-middle text-center no-hover">Subtotal Sodexo:</th>
<th class="align-middle text-center no-hover fw-normal">$ ' . number_format($SumSodexo, 2) . '</th>
</tr>';


echo '<tr class="tables-bg">
<th class="align-middle text-center tables-bg">GRAN TOTAL:</th>
<th class="align-middle text-center tables-bg">$ ' . number_format($SumGTotal, 2) . '</th>
</tr>';

echo '</tbody>
</table>
</div>
</div>';