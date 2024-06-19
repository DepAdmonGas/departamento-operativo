<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$ventas = $corteDiarioGeneral->ventas($idReporte);
$deshabilitado="";
$agregarProducto='<th colspan="5" class="align-middle text-center tables-bg">CONCENTRADO DE VENTAS</th>
			<th class="align-middle text-center tables-bg">
			<button type="button" class="btn btn-success" onclick="NewVentas(' . $idReporte . ')"><i class="fa fa-plus">
			</i></span></button>
			</th>
			';
if ($ventas == 1):
	$deshabilitado="disabledOP";
	$estado = "disabled";
	$agregarProducto='<th colspan="6" class="align-middle text-center tables-bg">CONCENTRADO DE VENTAS</th>';
endif;

?>
<script type="text/javascript">
	$(document).ready(function ($) {
		VentasSubTotales(<?= $idReporte; ?>);
		VentasTotales(<?= $idReporte; ?>);
	});

	function VentasSubTotales(idReporte) {
		$('#TrSubTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/concentrado-ventas-subtotales.php?idReporte=' + idReporte);
		//$('#TrSubTotales').load('../../../public/corte-diario/vistas/concentrado-ventas-subtotales.php?idReporte=' + idReporte);
	}

	function VentasTotales(idReporte) {
		$('#TrTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/concentrado-ventas-totales.php?idReporte=' + idReporte);
		//$('#TrTotales').load('../../../public/corte-diario/vistas/concentrado-ventas-totales.php?idReporte=' + idReporte);
	}

</script>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>corte-venta-dia-function.js"></script>
<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
		<?=$agregarProducto?>
			<tr>
				<td class="text-center align-middle fw-bold">PRODUCTO</td>
				<th class="text-center align-middle">LITROS</th>
				<th class="text-center align-middle">JARRAS</th>
				<th class="text-center align-middle">TOTAL LITROS</th>
				<th class="text-center align-middle">PRECIO POR LITRO</th>
				<td class="text-center align-middle fw-bold">IMPORTE TOTAL</td>
			</tr>
		</thead>

		<tbody class="bg-white">
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

					<th class="p-0 no-hover">
						<select class="form-select <?=$deshabilitado?>" id="producto-<?= $idventas; ?>"
							style="border: 0px;width: 100%;padding: 3px;font-size: 1.2em;"
							onchange="EditProducto(this,<?= $idReporte; ?>,<?= $idventas; ?>)" <?= $estado; ?>>
							<?php if ($producto == "") { ?>
								<option value="">PRODUCTO</option>
								<option value="G SUPER">G SUPER</option>
								<option value="G PREMIUM">G PREMIUM</option>
								<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G SUPER") { ?>
									<option value="<?=$producto?>"><?= $producto; ?></option>
									<option value="G PREMIUM">G PREMIUM</option>
									<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G PREMIUM") { ?>
										<option value="<?=$producto?>><?= $producto; ?></option>
										<option value="G SUPER">G SUPER</option>
										<option value="G DIESEL">G DIESEL</option>
							<?php } else if ($producto == "G DIESEL") { ?>
											<option value="<?=$producto?>"><?= $producto; ?></option>
											<option value="G SUPER">G SUPER</option>
											<option value="G PREMIUM">G PREMIUM</option>
							<?php } ?>

						</select>
					</th>

					<th class="p-0 align-middle no-hover <?=$deshabilitado?>">
						<input id="litros-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
							onkeyup="EditLitros(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $litros; ?>" <?= $estado; ?>>
					</th>

					<th class="p-0 align-middle no-hover <?=$deshabilitado?>">
						<input id="jarras-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%;text-align: right;"
							onkeyup="EditJarras(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $jarras; ?>" <?= $estado; ?>>
					</th>

					<th class="bg-white align-middle text-end" id="totallitros-<?= $idventas; ?>">
						<strong><?= number_format($totalLitros, 2); ?></strong></th>
					<th class="p-0 align-middle no-hover <?=$deshabilitado?>">
						<input id="preciolitro-<?= $idventas; ?>" type="number" min="0" step="any"
							style="border: 0px;width: 100%;padding: 3px;height: 100%;text-align: right;"
							onkeyup="EditPrecioLitro(this,<?= $idReporte; ?>,<?= $idventas; ?>)" value="<?= $preciolitro; ?>"
							<?= $estado; ?>>
					</th>
					<th class="bg-white align-middle text-end" id="importetotal-<?= $idventas; ?>">
						<strong><?= number_format($importeTotal, 2); ?></strong></th>


				</tr>
				<?php
			}
			?>
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
					$cssaceite = "bg-white text-end";

				} else {
					$disabled = "";
					$cssaceite = "p-0";
				}
				?>
				<tr class="bg-white">
					<th class="no-hover"><?= $concepto; ?></th>
					<td class="no-hover align-middle text-end"><?= $piezas; ?></td>
					<td class="no-hover align-middle text-end"></td>
					<td class="no-hover align-middle text-end"></td>
					<td class="no-hover align-middle text-end"></td>
					<td class="no-hover align-middle <?= $cssaceite; ?>">
						<?php
						if ($disabled == "disabled") {
							echo "<b>" . number_format($importe, 2) . "</b>";
						} else { ?>
							<input class="<?=$deshabilitado?>" id="preciootros-<?= $idOtros; ?>" type="number" min="0" step="any"
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