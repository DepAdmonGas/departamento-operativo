<?php
require ('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];

$sql_credito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Crédito' AND op_cliente.estado = 1 ORDER BY op_cliente.cliente ASC ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

$sql_debito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Débito' AND op_cliente.estado = 1 ORDER BY op_cliente.cliente ASC ";
$result_debito = mysqli_query($con, $sql_debito);
$numero_debito = mysqli_num_rows($result_debito);

$TSIC = 0;
$TCC = 0;
$TPC = 0;
$TSFC = 0;

$TSID = 0;
$TCD = 0;
$TPD = 0;
$TSFD = 0;
?> 

<div class="col-12">
<div class="table-responsive">
<table id="resumen-clientes-credito" class="custom-table" style="font-size: .80em;" width="100%">

<thead class="title-table-bg">
<tr class="tables-bg">
<th class="text-center align-middle fw-bold" colspan="7">Crédito</th>
</tr>

<tr>
<td class="fw-bold align-middle text-center">#</td>
<th class="align-middle text-center">Cuenta</th>
<th class="align-middle text-center">Cliente</th>
<th class="align-middle text-end">Saldo inicio</th>
<th class="align-middle text-end">Consumos</th>
<th class="align-middle text-end">Pagos</th>
<td class="fw-bold align-middle text-end">Saldo final</td>
</tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_credito > 0):
while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)):
$id = $row_credito['id'];

echo '<tr>
<th class="align-middle text-center"  style="font-size: .9em;">' . $row_credito['id'] . '</th>
<td class="align-middle"  style="font-size: .9em;">' . $row_credito['cuenta'] . '</td>
<td class="align-middle"  style="font-size: .9em;">' . $row_credito['cliente'] . '</td>
<td class="text-end p-0"> 
<input id="ESICredito' . $id . '" class="border-0 text-end p-3" style="width: 100%;height:100%;font-size: 1em;" type="number" value="' . $row_credito['saldo_inicial'] . '" onkeyup="ESICredito(' . $id . ')" /> 
</td>
<td class="text-end">$ ' . number_format($row_credito['consumos'], 2) . '</td>
<td class="text-end">$ ' . number_format($row_credito['pagos'], 2) . '</td>
<td class="text-end" id="SaldoF' . $id . '">$ ' . number_format($row_credito['saldo_final'], 2) . '</td>
</tr>';

$TSIC += $row_credito['saldo_inicial'];
$TCC += $row_credito['consumos'];
$TPC += $row_credito['pagos'];
$TSFC += $row_credito['saldo_final'];
endwhile;
endif;

echo '
<tr class="ultima-fila">
<th colspan="3" class="text-end tables-bg">Total Crédito</th>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSIC, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TCC, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TPC, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSFC, 2) . '</td>
</tr>';
?>

</tbody>
</table>
</div>
</div>

<hr>

<div class="col-12">
<div class="table-responsive">
<table id="resumen-clientes-debito" class="custom-table" style="font-size: .75em;" width="100%">
<thead class="title-table-bg">
<tr class="tables-bg">
<th class="text-center align-middle fw-bold" colspan="7">Débito</th>
</tr>

<tr>
<td class="fw-bold align-middle text-center">#</td>
<th class="align-middle text-center">Cuenta</th>
<th class="align-middle text-center">Cliente</th>
<th class="align-middle text-end">Saldo inicio</th>
<th class="align-middle text-end">Consumos</th>
<th class="align-middle text-end">Pagos</th>
<td class="fw-bold align-middle text-end">Saldo final</td>
</tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_debito > 0):
while ($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)):
$id = $row_debito['id'];
$saldofinalD = $row_debito['saldo_inicial'] + $row_debito['consumos'] - $row_debito['pagos'];
$sql_edit = "UPDATE op_consumos_pagos_resumen SET saldo_final = '" . $saldofinalD . "' WHERE id ='" . $id . "' ";
mysqli_query($con, $sql_edit);

echo '<tr>
<th class="align-middle text-center" style="font-size: .9em;">' . $row_debito['id'] . '</th>
<td class="align-middle" style="font-size: .9em;">' . $row_debito['cuenta'] . '</td>
<td class="align-middle" style="font-size: .9em;">' . $row_debito['cliente'] . '</td>
<td class="text-end p-0">  <input id="ESICredito' . $id . '" class="border-0 text-end p-3" style="width: 100%;height:100%;font-size: 1em;" type="number" value="' . $row_debito['saldo_inicial'] . '" onkeyup="ESICredito(' . $id . ')" /> </td>
<td class="text-end">$ ' . number_format($row_debito['consumos'], 2) . '</td>
<td class="text-end">$ ' . number_format($row_debito['pagos'], 2) . '</td>
<td class="text-end" id="SaldoF' . $id . '">$ ' . number_format($row_debito['saldo_final'], 2) . '</td>
</tr>';

$TSID += $row_debito['saldo_inicial'];
$TCD += $row_debito['consumos'];
$TPD += $row_debito['pagos'];
$TSFD += $row_debito['saldo_final'];
endwhile;

echo '
<tr class="ultima-fila">
<th colspan="3" class="text-end fw-bold tables-bg">Total Débito</th>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSID, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TCD, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TPD, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSFD, 2) . '</td>
</tr>

<tr class="ultima-fila">
<th colspan="3" class="fw-bold text-end tables-bg">GRAN TOTAL</th>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSIC + $TSID, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TCC + $TCD, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TPC + $TPD, 2) . '</td>
<td class="text-end fw-bold tables-bg">$ ' . number_format($TSFC + $TSFD, 2) . '</td>
</tr>';
endif;
?>

</tbody>
</table>
</div>
</div>
