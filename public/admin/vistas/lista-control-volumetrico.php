<?php

require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];

$sql_lista = "SELECT * FROM op_control_volumetrico WHERE id_mes = '" . $IdReporte . "' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<?php
$verificar = '<th colspan="4" class="align-middle text-center tables-bg">ACEITES</th>';

if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") :
	$verificar ='<th colspan="3" class="align-middle text-center">ACEITES</th>
				<th class="align-middle"> 
					<button type="button" class="btn btn-success" onclick="btnModal()"><i class="fa fa-plus">
					</i></span></button>
				</th>
				';
endif;
?>

<div class="table-responsive mt-3">
	<table class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="navbar-bg">
			<tr class="tables-bg">
				<?= $verificar ?>
			</tr>
			<tr>
				<td class="align-middle text-center fw-bold">FECHA</td>
				<th class="align-middle text-center">ANEXOS</th>
				<th class="align-middle text-center" width="24">
					<img src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
				</th>
				<td class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png">
				</td>
			</tr>

		</thead>
		<tbody class="bg-white">
			<?php
			if ($numero_lista > 0) {
				while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

					if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
						$eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $IdReporte . ',' . $row_lista['id'] . ')">';
					} else {
						$eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" >';
					}

					$extension = pathinfo($row_lista['documento'], PATHINFO_EXTENSION);

					if ($extension == "xml" || $extension == "XML") {
						$icon = RUTA_IMG_ICONOS . 'xml.png';
					} else if ($extension == "pdf") {
						$icon = RUTA_IMG_ICONOS . 'pdf.png';
					} else if ($extension == "xlsx") {
						$icon = RUTA_IMG_ICONOS . 'excel.png';
					} else if ($extension == "zip" || $extension == "ZIP") {
						$icon = RUTA_IMG_ICONOS . 'zip.png';
					} else if ($extension == "xlsx" || $extension == "xls") {
						$icon = RUTA_IMG_ICONOS . 'excel.png';
					}

					$fechahora = explode(' ', $row_lista['fecha_hora']);
					echo '<tr>';
					echo '<th class="align-middle">' . FormatoFecha($fechahora[0]) . '</th>';
					echo '<td class="align-middle">' . $row_lista['anexos'] . '</td>';
					echo '<td><a href="../../../../archivos/' . $row_lista['documento'] . '" download><img src="' . $icon . '"></a></td>';
					echo '<td width="20">' . $eliminar . '</td>';
					echo '</tr>';

				}
			} else {
				echo "<tr><th colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
			}
			?>
		</tbody>
	</table>

</div>