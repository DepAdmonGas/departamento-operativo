<?php
require ('../../../../../help.php');

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


function Resumen($idReporte, $tipo, $consumo, $con)
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


$DC = Resumen($idReporte, mb_convert_encoding('Débito', 'UTF-8', 'ISO-8859-1'), 'Consumo', $con);
$DP = Resumen($idReporte, mb_convert_encoding('Débito', 'UTF-8', 'ISO-8859-1'), 'Pago', $con);
$CC = Resumen($idReporte, mb_convert_encoding('Crédito', 'UTF-8', 'ISO-8859-1'), 'Consumo', $con);
$CP = Resumen($idReporte, mb_convert_encoding('Crédito', 'UTF-8', 'ISO-8859-1'), 'Pago', $con);

$sql1 = "UPDATE op_clientes_controlgas SET pago = '" . $DP . "', consumo = '" . $DC . "' WHERE idreporte_dia ='" . $idReporte . "' AND concepto = 'DEBITO (ANEXO)' ";
mysqli_query($con, $sql1);

$sql2 = "UPDATE op_clientes_controlgas SET pago = '" . $CP . "', consumo = '" . $CC . "' WHERE idreporte_dia ='" . $idReporte . "' AND concepto = 'CRÉDITO (ANEXO)' ";
mysqli_query($con, $sql2);


?>
<div class="table-responsive">
	<table id="tabla-principal" class="custom-table " style="font-size: 1em;" width="100%">
		<thead class="navbar-bg">
			<tr>
				<th class="align-middle text-center">#</th>
				<th class="align-middle text-start">Cliente</th>
				<th class="align-middle text-start">Nombre</th>
				<th class="align-middle text-center">Tipo</th>
				<th class="align-middle text-center ">Consumo/Pago</th>
				<th class="align-middle text-center ">Forma Pago</th>
				<th class="align-middle text-center  text-center" width="20px"><img width="20px"
						src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
				<th class="align-middle text-center " class="text-end">Total</th>
				<th class="align-middle text-center " width="20px">
					<img width="20px" src="<?= RUTA_IMG_ICONOS; ?>eliminar.png">
				</th>
			</tr>
		</thead>
		<tbody class="bg-white">
			<?php
			$Topago = 0;
			$consumo = 0;
			$Toconsumo = 0;
			if ($numero_credito > 0) :
				while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) :

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
					if ($row_credito['tipo'] == "Crédito") {
						$CTipo = "text-primary";
					} else if ($row_credito['tipo'] == "Débito") {
						$CTipo = "text-success";
					}


					echo '<tr>
							<th class="align-middle font-weight-light text-center"  style="font-size: 1em;">' . $row_credito['id'] . '</th>
							<td class="align-middle font-weight-light">' . $row_credito['cuenta'] . '</td>
							<td class="align-middle font-weight-light text-start">' . $row_credito['cliente'] . '</td>
							<td class="align-middle font-weight-light ' . $CTipo . ' ">' . $row_credito['tipo'] . '</td>
							<td class="align-middle font-weight-light">' . $row_credito['ConsumoTipo'] . '</td>
							<td class="align-middle font-weight-light">' . $TipoPago . '</td>
							<td class="align-middle font-weight-light text-center">' . $comprobante . '</td>
							<td class="align-middle text-end"><b>$' . number_format($row_credito['total'], 2) . '</b></td>
							<td class="align-middle text-center" width="20px">
							<img width="20px" class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $idReporte . ',' . $id . ' '.RUTA_JS2.')">
							</td>
						</tr>';
				endwhile;
			endif;
			?>
		</tbody>
	</table>
</div>

<div class="justify-content-center mt-3">
	<table class="custom-table" style="font-size: 1em; width: 100%;">
		<thead class="navbar-bg">
			<tr>
				<th class="tables-bg" colspan="3">Totales</th>
			</tr>
			<tr>
				<td class="text-center fw-bold">Tipo</td>
				<th class="text-center ">Consumo</th>
				<td class="text-center fw-bold">Pago</td>
			</tr>
		</thead>
		<tbody class="bg-white">
			<tr>
				<th class="text-success text-center fw-bold no-hover">Débito</th>
				<td class="text-end pl-4 pr-2 font-weight-light no-hover">$
					<?= number_format(Resumen($idReporte, 'Débito', 'Consumo', $con), 2); ?>
				</td>
				<td class="text-end pl-4 pr-2 font-weight-light no-hover">$
					<?= number_format(Resumen($idReporte, 'Débito', 'Pago', $con), 2); ?>
				</td>
			</tr>
			<tr>
				<th class="text-primary text-center fw-bold no-hover">Crédito</th>
				<td class="text-end pl-4 pr-2 font-weight-light no-hover">$
					<?= number_format(Resumen($idReporte, 'Crédito', 'Consumo', $con), 2); ?>
				</td>
				<td class="text-end pl-4 pr-2 font-weight-light no-hover">$
					<?= number_format(Resumen($idReporte, 'Crédito', 'Pago', $con), 2); ?>
				</td>
			</tr>
			<tr>
				<th class="text-center fw-bold no-hover">Total</th>
				<td class="text-end no-hover"><b>$ <?=number_format($Toconsumo, 2)?></b></td>
				<td colspan="3" class="text-end no-hover"><b>$ <?=number_format($Topago, 2)?></b></td>
			</tr>
		</tbody>
	</table>

</div>