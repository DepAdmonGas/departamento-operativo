<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div class="table-responsive">
	<table class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="tables-bg">
			<th colspan="3" class="text-center fw-bold">CLIENTES (ATIO)</th>
			<tr class="title-table-bg">
				<td class="text-center fw-bold">CONCEPTO</td>
				<th class="text-center">PAGOS</th>
				<td class="text-center fw-bold">CONSUMOS</td>
			</tr>
		</thead>
		<tbody class="bg-white">
			<?php
			$topago = 0;
			$toconsumo = 0;
			$sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $idReporte . "' ";
			$result_listacontrol = mysqli_query($con, $sql_listacontrol);
			while ($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)) {

				$idControl = $row_listacontrol['id'];
				$concepto = $row_listacontrol['concepto'];

				$pago = $row_listacontrol['pago'];

				$consumo = $row_listacontrol['consumo'];

				$topago = $topago + $row_listacontrol['pago'];
				$toconsumo = $toconsumo + $row_listacontrol['consumo'];

				?>

				<tr>
					<th class="no-hover align-middle"><?= $concepto; ?></th>
					<td class="p-1 no-hover align-middle text-end">
						<?= number_format($pago, 2); ?>
					</td>
					<td class="p-1 no-hover align-middle text-end">
						<?= number_format($consumo, 2); ?>
					</td>
				</tr>

				<?php
			}

			?>
			<tr>
				<th class="disabledOP text-center">TOTAL 3</th>
				<td class="disabledOP align-middle text-end"><strong><?= number_format($topago, 2); ?></strong></td>
				<td class="disabledOP align-middle text-end"><strong><?= number_format($toconsumo, 2); ?></strong></td>
			</tr>

		</tbody>
	</table>
</div>