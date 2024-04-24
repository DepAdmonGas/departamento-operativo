<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_credito = "SELECT
op_consumos_pagos.id,
op_consumos_pagos.id_reportedia,
op_consumos_pagos.id_cliente,
op_consumos_pagos.total,
op_consumos_pagos.tipo AS ConsumoTipo,
op_consumos_pagos.pago,
op_consumos_pagos.comprobante,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo
FROM op_consumos_pagos 
INNER JOIN op_cliente
ON op_consumos_pagos.id_cliente = op_cliente.id
WHERE op_consumos_pagos.id_reportedia = '" . $idReporte . "' ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);


function Resumen($idReporte, $tipo, $consumo,$con)
{


	$sql_credito = "SELECT
op_consumos_pagos.id,
op_consumos_pagos.id_reportedia,
op_consumos_pagos.id_cliente,
op_consumos_pagos.total,
op_consumos_pagos.tipo AS ConsumoTipo,
op_consumos_pagos.pago,
op_consumos_pagos.comprobante,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo
FROM op_consumos_pagos 
INNER JOIN op_cliente
ON op_consumos_pagos.id_cliente = op_cliente.id
WHERE op_consumos_pagos.id_reportedia = '" . $idReporte . "' AND op_cliente.tipo = '" . $tipo . "' AND op_consumos_pagos.tipo = '" . $consumo . "' ";
	$result_credito = mysqli_query($con, $sql_credito);
	$numero_credito = mysqli_num_rows($result_credito);
	$total = 0;
	while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {
		$total = $total + $row_credito['total'];
	}

	return $total;
}


$DC = Resumen($idReporte, utf8_encode('Débito'), 'Consumo', $con);
$DP = Resumen($idReporte, utf8_encode('Débito'),'Pago',$con);
$CC = Resumen($idReporte, utf8_encode('Crédito'),'Consumo',$con);
$CP = Resumen($idReporte, utf8_encode('Crédito'),'Pago',$con);

$sql1 = "UPDATE op_clientes_controlgas SET pago = '" . $DP . "', consumo = '" . $DC . "' WHERE idreporte_dia ='" . $idReporte . "' AND concepto = 'DEBITO (ANEXO)' ";
mysqli_query($con, $sql1);

$sql2 = "UPDATE op_clientes_controlgas SET pago = '" . $CP . "', consumo = '" . $CC . "' WHERE idreporte_dia ='" . $idReporte . "' AND concepto = 'CRÉDITO (ANEXO)' ";
mysqli_query($con, $sql2);


?>
<table class="table table-sm table-bordered pb-0 mb-0">
	<thead>
		<tr>
			<th class="align-middle text-center bg-light" class="text-center">#</th>
			<th class="align-middle bg-light" colspan="3">Cliente</th>
			<th class="align-middle bg-light">Consumo/Pago</th>
			<th class="align-middle bg-light">Forma Pago</th>
			<th class="align-middle bg-light text-center" width="20px"><img width="20px"
					src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
			<th class="align-middle bg-light" class="text-end">Total</th>
			<th class="align-middle bg-light" width="20px">
				<img width="20px" src="<?= RUTA_IMG_ICONOS; ?>eliminar.png">
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$Topago = 0;
		$consumo = 0;
		$Toconsumo = 0;
		if ($numero_credito > 0) {
			while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {

				$id = $row_credito['id'];

				if ($row_credito['ConsumoTipo'] == "Consumo") {
					$consumo = $row_credito['total'];
					$Toconsumo = $Toconsumo + $consumo;
				} else if ($row_credito['ConsumoTipo'] == "Pago") {
					$pago = $row_credito['total'];
					$Topago = $Topago + $pago;
				}

				if ($row_credito['pago'] == "") {
					$TipoPago = "N/A";
				} else {
					$TipoPago = $row_credito['pago'];
				}

				if ($row_credito['comprobante'] == "") {
					$comprobante = "N/A";
				} else {
					$comprobante = '<a href="../../../archivos/' . $row_credito['comprobante'] . '" download><img width="20px" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
				}
				$CTipo = "";
				if (utf8_encode($row_credito['tipo']) == "Crédito") {
					$CTipo = "text-primary";
				} else if (utf8_encode($row_credito['tipo']) == "Débito") {
					$CTipo = "text-success";
				}


				echo '<tr>
<td class="align-middle font-weight-light text-center"  style="font-size: 1em;">' . $row_credito['id'] . '</td>
<td class="align-middle font-weight-light">' . $row_credito['cuenta'] . '</td>
<td class="align-middle font-weight-light">' . $row_credito['cliente'] . '</td>
<td class="align-middle font-weight-light '.$CTipo.' ">'.utf8_encode($row_credito['tipo']).'</td>
<td class="align-middle font-weight-light">' . $row_credito['ConsumoTipo'] . '</td>
<td class="align-middle font-weight-light">' . $TipoPago . '</td>
<td class="align-middle font-weight-light text-center">' . $comprobante . '</td>
<td class="align-middle text-end"><b>$ ' . number_format($row_credito['total'], 2) . '</b></td>
<td class="align-middle text-center" width="20px">
<img width="20px" class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $idReporte . ',' . $id . ')">
</td>
</tr>';

			}
			echo '<tr>
<td colspan="6" class="align-middle text-end"><b>Total Concumo:</b></td>
<td colspan="2" class="text-end"><b>$ ' . number_format($Toconsumo, 2) . '</b></td>
</tr>
<tr>
<td colspan="6" class="align-middle text-end"><b>Total Pago:</b></td>
<td colspan="2" class="text-end"><b>$ ' . number_format($Topago, 2) . '</b></td>

</tr>';
		} else {
			echo '<tr><td colspan="9" class="text-center"><small>No se encontró información</small></td></tr>';
		}
		?>
	</tbody>
</table>

<div class="float-end mt-3">

	<table class="table table-bordered pb-0 mb-0" style="font-size: 1em;">
		<tr class="tables-bg">
			<td class="pl-4 pr-4 pt-2 pb-2 text-center font-weight-light"></td>
			<td class="pl-4 pr-4 pt-2 pb-2 text-center font-weight-light"><b>Consumo</b></td>
			<td class="pl-4 pr-4 pt-2 pb-2 text-center font-weight-light"><b>Pago</b></td>
		</tr>
		<tr>
			<td class="text-success pl-4 pr-4 text-center font-weight-light">Débito</td>
			<td class="text-end pl-4 pr-2 font-weight-light">$
				<?= number_format(Resumen($idReporte, 'Débito', 'Consumo', $con), 2); ?></td>
			<td class="text-end pl-4 pr-2 font-weight-light">$
				<?= number_format(Resumen($idReporte, 'Débito', 'Pago', $con), 2); ?></td>
		</tr>
		<tr>
			<td class="text-primary pl-4 pr-4 text-center font-weight-light">Crédito</td>
			<td class="text-end pl-4 pr-2 font-weight-light">$
				<?= number_format(Resumen($idReporte, 'Crédito', 'Consumo', $con), 2); ?></td>
			<td class="text-end pl-4 pr-2 font-weight-light">$
				<?= number_format(Resumen($idReporte, 'Crédito', 'Pago', $con), 2); ?></td>
		</tr>
	</table>

</div>