<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
	$estado = "disabled";
endif;
?> 



<div style="overflow-y: hidden;">

	<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
		<thead class="tables-bg">
			<th class="text-center align-middle">PRODUCTO</th>
			<th class="text-center align-middle">LITROS</th>
			<th class="text-center align-middle">JARRAS</th>
			<th class="text-center align-middle">TOTAL LITROS</th>
			<th class="text-center align-middle">PRECIO POR LITRO</th>
			<th class="text-center align-middle">IMPORTE TOTAL</th>
		</thead>

		<tbody>
			<?php

			$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idReporte . "' ";
			$result_listayear = mysqli_query($con, $sql_listayear);
			$numero_reporte = mysqli_num_rows($result_listayear);

			while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

				$idventas = $row_listayear['id'];
				$producto = $row_listayear['producto'];
				$litrosventas = $row_listayear['litros'];
				$jarrasventas = $row_listayear['jarras'];
				$precio_litroventas = $row_listayear['precio_litro'];

				if ($litrosventas == 0) {
					$litros = "";
				} else {
					$litros = number_format($litrosventas, 2, '.', '');
				}

				if ($jarrasventas == 0) {
					$jarras = "";
				} else {
					$jarras = number_format($jarrasventas, 2, '.', '');
				}

				if ($precio_litroventas == 0) {
					$preciolitro = "";
				} else {
					$preciolitro = number_format($precio_litroventas, 2, '.', '');
				}

				$totalLitros = $litrosventas - $jarrasventas;
				$importeTotal = $totalLitros * $precio_litroventas;
				?>
				<tr>

					<td class="p-0">
						<select class="form-select" id="producto-<?= $idventas; ?>"
							style="border: 0px;width: 100%;padding: 3px;font-size: 1.2em;"
							onchange="EditProducto(this,<?= $idReporte; ?>,<?= $idventas; ?>)" <?= $estado; ?>>
							<?php if ($producto == "") { ?>
								<option value="">PRODUCTO</option>
								<option value="G SUPER">G SUPER</option>
								<option value="G PREMIUM">G PREMIUM</option>
								<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G SUPER") { ?>
									<option value="<?= $producto; ?>"><?= $producto; ?></option>
									<option value="G PREMIUM">G PREMIUM</option>
									<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G PREMIUM") { ?>
										<option value="<?= $producto; ?>"><?= $producto; ?></option>
										<option value="G SUPER">G SUPER</option>
										<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G DIESEL") { ?>
											<option value="<?= $producto; ?>"><?= $producto; ?></option>
											<option value="G SUPER">G SUPER</option>
											<option value="G PREMIUM">G PREMIUM</option>
							<?php } ?>

						</select>
					</td>

					<td class="p-0 align-middle">
						<input id="litros-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
							onkeyup="EditLitros(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $litros; ?>" <?= $estado; ?>>
					</td>

					<td class="p-0 align-middle">
						<input id="jarras-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%;text-align: right;"
							onkeyup="EditJarras(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $jarras; ?>" <?= $estado; ?>>
					</td>

					<td class="bg-light align-middle text-end" id="totallitros-<?= $idventas; ?>">
						<strong><?= number_format($totalLitros, 2); ?></strong></td>
					<td class="p-0 align-middle">
						<input id="preciolitro-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%;text-align: right;"
							onkeyup="EditPrecioLitro(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $preciolitro; ?>"
							<?= $estado; ?>>
					</td>
					<td class="bg-light align-middle text-end" id="importetotal-<?= $idventas; ?>">
						<strong><?= number_format($importeTotal, 2); ?></strong></td>


				</tr>
				<?php
			}
			?>


			<tr>
				<td colspan="6"></td>
			</tr>
			<tr id="TrSubTotales"></tr>
			<?php
			$sql_listaotros = "SELECT * FROM op_ventas_dia_otros WHERE idreporte_dia = '" . $idReporte . "' ";
			$result_listaotros = mysqli_query($con, $sql_listaotros);
			while ($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)) {

				$idOtros = $row_listaotros['id'];
				$concepto = $row_listaotros['concepto'];
				$piezas = $row_listaotros['piezas'];
				$importe = 0;
				if ($row_listaotros['importe'] != 0) {
					$importe = number_format($row_listaotros['importe'], 2, '.', '');
				}

				if ($concepto == "4 ACEITES Y LUBRICANTES") {
					$disabled = "disabled";
					$cssaceite = "bg-light text-end";

				} else {
					$disabled = "";
					$cssaceite = "p-0";
				}
				?>
				<tr>
					<td><?= $concepto; ?></td>
					<td class="bg-light align-middle text-end"><?= $piezas; ?></td>
					<td class="bg-light align-middle text-end"></td>
					<td class="bg-light align-middle text-end"></td>
					<td class="bg-light align-middle text-end"></td>
					<td class="align-middle <?= $cssaceite; ?>">
						<?php
						if ($disabled == "disabled") {
							echo "<b>" . number_format($importe, 2) . "</b>";
						} else { ?>
							<input id="preciootros-<?= $idOtros; ?>" type="number" min="0" step="any"
								style="border: 0px;width: 100%;padding: 3px;height: 100% !important;text-align: right;"
								onkeyup="EditPrecioOtros(this,<?= $idReporte; ?>,<?= $idOtros; ?>)" value="<?= $importe; ?>"
								<?= $estado; ?>>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>

			<tr id="TrTotales"></tr>
		</tbody>
	</table>
</div>