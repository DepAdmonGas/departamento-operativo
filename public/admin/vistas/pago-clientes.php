<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th colspan="3" class="text-center fw-bold">PAGO DE CLIENTES</th>
      <tr class="title-table-bg">
				<td class="text-center fw-bold">CONCEPTO</td>
				<th class="text-center">IMPORTE</th>
				<td class="text-center fw-bold">NOTA</td>
			</tr>
		</thead>
		<tbody class="bg-white">
			<?php
      $totalImporte = 0;
			$sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '" . $idReporte . "' ";
			$result_listaclientes = mysqli_query($con, $sql_listaclientes);
			while ($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)) {

				$idPagoCliente = $row_listaclientes['id'];
				$concepto = $row_listaclientes['concepto'];
				$nota = $row_listaclientes['nota'];


				$importe = $row_listaclientes['importe'];

				$totalImporte = $totalImporte + $importe;

				?>

				<tr>
					<th class="align-middle no-hover"><?= $concepto; ?></th>
					<td class="p-1 align-middle no-hover text-end">
						<?= number_format($importe, 2); ?>
					</td>
					<td class="p-1 align-middle no-hover">
						<?= $nota; ?>
					</td>
				</tr>

				<?php
			}

			?>
			<tr>
				<th class="text-center no-hover">TOTAL 4</th>
				<td colspan="2" class="align-middle text-center no-hover"><strong><?= number_format($totalImporte, 2); ?></strong></td>
			</tr>
		</tbody>
	</table>
</div>