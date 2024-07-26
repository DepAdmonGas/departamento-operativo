<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
			<th colspan="5" class="align-middle text-center tables-bg">RELACION DE VENTA DE ACEITES Y LUBRICANTES</th>

			<tr>
				<td colspan="2" class="align-middle text-center fw-bold">CONCEPTO</td>
				<th class="align-middle text-center">CANTDAD</th>
				<th class="align-middle text-center">PRECIO UNITARIO</th>
				<td class="align-middle text-center fw-bold">IMPORTE</td>
			</tr>

		</thead>
		<tbody class="bg-white">
			<?php
			$totalCantidad = 0;
			$totalPrecio = 0;
			$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $idReporte . "' ";
			$result_listaaceites = mysqli_query($con, $sql_listaaceites);
			while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

				$idAceite = $row_listaaceites['id'];
				$numAceite = $row_listaaceites['id_aceite'];
				$concepto = $row_listaaceites['concepto'];
        $cantidad = $row_listaaceites['cantidad'];
        $precio = number_format($row_listaaceites['precio_unitario'], 2, '.', '');
				if ($row_listaaceites['cantidad'] == 0) {
					$cantidad = "";
				}

				if ($row_listaaceites['precio_unitario'] == 0) {
					$precio = "";
				}

				$importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];

				$totalCantidad += $row_listaaceites['cantidad'];
				$totalPrecio += $importe;
				?>

				<tr>
					<th class="align-middle no-hover"><?= $numAceite; ?></th>
					<td class="align-middle no-hover"><?= $concepto; ?></td>
					<td class="p-0 align-middle text-center no-hover">
						<?= $cantidad; ?>
					</td>
					<td class="align-middle text-end no-hover" id="precioAL-<?= $idAceite; ?>">
						<?= $precio; ?>
					</td>
					<td class="align-middle text-end no-hover" id="importeAL-<?= $idAceite; ?>"><?= number_format($importe, 2); ?></td>
				</tr>

				<?php
			}

			?>
			<tr>
				<th class="text-start disabledOP" colspan="2">Total</th>
				<td class="align-middle text-center disabledOP"><strong><?= $totalCantidad; ?></strong></td>
				<td class="align-middle text-end disabledOP" colspan="2"><strong><?= number_format($totalPrecio, 2); ?></strong></td>
			</tr>
		</tbody>
	</table>
</div>