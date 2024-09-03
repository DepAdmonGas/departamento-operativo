<?php
require ('../../../../help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
	$estacion = $row_listaestacion['nombre'];
}

$sql = "SELECT * FROM op_rh_puestos ORDER BY puesto ASC";
$result = mysqli_query($con, $sql);

function Puesto($idPuesto, $con)
{
	$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '" . $idPuesto . "' ";
	$result = mysqli_query($con, $sql);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$puesto = $row['puesto'];
	}

	return $puesto;
}

?>

	<h5 class="modal-title">Formulario alta de personal <?= $estacion; ?></h5>

	<div class="row">


		<div class="col-12 mb-3">
			<span class="badge rounded-pill tables-bg float-end" style="font-size:12.2px">No. De control: 001</span>
		</div>

		<div class="col-12 mb-3">
			<h6>* Fecha de ingreso</h6>
			<input type="date" class="form-control rounded-0" id="FechaIngreso">
		</div>

		<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
			<h6>* Nombre(s)</h6>
			<input type="text" class="form-control" id="Nombres">
		</div>

		<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
			<h6>* Apellido Paterno</h6>
			<input type="text" class="form-control" id="ApellidoP">
		</div>

		<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
			<h6>* Apellido Materno</h6>
			<input type="text" class="form-control" id="ApellidoM">
		</div>

		<div class="col-12 mb-2">
			<h6>* Puesto</h6>
			<select class="form-select" id="Puesto">
				<option value=""></option>
				<?php
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$puesto = $row['puesto'];
					echo '<option value="' . $row['id'] . '">' . $puesto . '</option>';
				}
				?>
			</select>
		</div>


		<div class="col-12 mb-2">
			<h6>* Identificación oficial (vigente, elector o pasaporte)</h6>
			<input type="file" class="form-control rounded-0" id="INE">
		</div>

		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
			<h6>* CURP</h6>
			<input type="file" class="form-control rounded-0" id="CURP">
		</div>

		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
			<h6>* RFC</h6>
			<input type="file" class="form-control rounded-0" id="RFC">
		</div>

		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
			<h6>* NSS</h6>
			<input type="file" class="form-control rounded-0" id="NSS">
		</div>


		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
			<h6>* Salario diario:</h6>
			<input type="number" class="form-control" id="SalarioD">
		</div>



		<div class="col-12 mb-1">
			<div class="border p-3 mb-2">
				<h6>* Documentos personales:</h6>

				<div class="col-12">
					<input class="form-control" type="file" id="Documento">
				</div>

				<hr>
				<ol class="font-weight-light">
					<li>Requisición de personal</li>
					<li>Solicitud de empleo (a puño y letra)</li>
					<li>Acta de nacimiento (certificada)</li>
					<li>Comprobante de domicilio (Recibo de tel., agua o predio, con antigüedad máxima de tres meses)
					</li>
					<li>Ultimo comprobante de estudios </li>
					<li>Cartas de recomendación de últimos empleos (hoja membretada con dirección y teléfono)</li>
					<li>Aviso de retención de Infonavit</li>
					<li>Carta de antecedentes no penales (solo para despachadores)</li>
				</ol>


				<div class="alert alert-warning text-center" role="alert">
					<b>Nota: </b> los archivos anteriormente mencionados deben de anexarse en un solo documento (PDF).
				</div>
			</div>
		</div>
		<div class="col-12">
			<h6 class="mt-3">* Detalle</h6>
			<textarea class="form-control" id="Detalle"></textarea>

		</div>
	</div>
	<hr>
	<div class="border">
		<div class="p-3">
			<div class="text-end">
				<button type="button" class="btn btn-primary btn-sm"
					onclick="GuardarPersonal(<?= $idEstacion; ?>,<?= $idReporte; ?>)">Agregar personal</button>
			</div>

			<hr>

			<div class="table-responsive">
				<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
					<thead>
						<tr class="tables-bg text-center">
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Fecha de ingreso</th>
							<th class="align-middle">Nombre empleado</th>
							<th class="align-middle">Puesto</th>
							<th class="align-middle">Identificacion Oficial</th>
							<th class="align-middle">CURP</th>
							<th class="align-middle">RFC</th>
							<th class="align-middle">NSS</th>
							<th class="align-middle text-end">Salario diario</th>
							<th class="align-middle">Detalle</th>
							<th class="align-middle">Documentos Personales</th>
							<th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"
									data-toggle="tooltip" data-placement="top" title="Eliminar"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '" . $idReporte . "' ";
						$result_lista = mysqli_query($con, $sql_lista);
						$numero_lista = mysqli_num_rows($result_lista);

						if ($numero_lista > 0) {
							while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
								$id = $row_lista['id'];

								$Fecha = $row_lista['fecha_ingreso'];
								$NombreC = $row_lista['nombres'] . ' ' . $row_lista['apellido_p'] . ' ' . $row_lista['apellido_m'];
								$puesto = Puesto($row_lista['puesto'], $con);
								$Documento = $row_lista['documento'];

								$curp = $row_lista['curp'];
								$rfc = $row_lista['rfc'];
								$nss = $row_lista['nss'];
								$ine = $row_lista['ine'];

								$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
								$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
								$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);

								if ($extensionCurp == "pdf" || $extensionCurp == "jpg" || $extensionCurp == "png" || $extensionCurp == "txt" || $extensionCurp == "xml" || $extensionCurp == "jpeg") {
									$detalleCurp = '<a href="' . RUTA_ARCHIVOS . '/documentos-personal/curp/' . $curp . '" download>
     								<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="CURP"></a>';

								} else {
									$detalleCurp = $curp;

								}


								if ($extensionRfc == "pdf" || $extensionRfc == "jpg" || $extensionRfc == "png" || $extensionRfc == "txt" || $extensionRfc == "xml" || $extensionRfc == "jpeg") {
									$detalleRfc = '<a href="' . RUTA_ARCHIVOS . '/documentos-personal/rfc/' . $rfc . '" download>
     								<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="RFC"></a>';

								} else {
									$detalleRfc = $rfc;

								}


								if ($extensionNss == "pdf" || $extensionNss == "jpg" || $extensionNss == "png" || $extensionNss == "txt" || $extensionNss == "xml" || $extensionNss == "jpeg") {
									$detalleNss = '<a href="' . RUTA_ARCHIVOS . '/documentos-personal/nss/' . $nss . '" download>
     								<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="Numero de Seguro Social"></a>';

								} else {
									$detalleNss = $nss;

								}


								if ($ine != "") {
									$detalleIne = '<a href="' . RUTA_ARCHIVOS . '/documentos-personal/ine/' . $ine . '" download>
     								<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';

								} else {
									$detalleIne = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';
								}



								echo '<tr class="">';
								echo '<td class="align-middle text-center"><b>' . $row_lista['id'] . '</b></td>';
								echo '<td class="align-middle text-center">' . FormatoFecha($Fecha) . '</td>';
								echo '<td class="align-middle text-center">' . $NombreC . '</td>';
								echo '<td class="align-middle text-center">' . $puesto . '</td>';

								echo '<td class="align-middle text-center">' . $detalleIne . '</td>';
								echo '<td class="align-middle text-center">' . $detalleCurp . '</td>';
								echo '<td class="align-middle text-center">' . $detalleRfc . '</td>';
								echo '<td class="align-middle text-center">' . $detalleNss . '</td>';

								echo '<td class="align-middle text-end">' . number_format($row_lista['sd'], 2) . '</td>';
								echo '<td class="align-middle text-center">' . $row_lista['detalle'] . '</td>';

								echo '<td class="align-middle text-center">
									<a href="' . RUTA_ARCHIVOS . '' . $Documento . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a>
									</td>';

								echo '<td class="align-middle text-center" onclick="Eliminar(' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>';
								echo '</tr>';
							}
						} else {
							echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>


	<button type="button" class="btn btn-success" onclick="Finalizar(<?= $idReporte; ?>,<?= $idEstacion; ?>)">Finalizar alta
		de personal</button>
