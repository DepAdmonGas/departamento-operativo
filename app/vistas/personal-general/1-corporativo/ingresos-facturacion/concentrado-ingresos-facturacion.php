<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
$year = $_GET['idYear'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

$idReporte = $corteDiarioGeneral->idReporteFacturacion($idEstacion, $year);
$corteDiarioGeneral->validaFacturacion($idReporte, 'general');
$GDiesel = $corteDiarioGeneral->getProducto($idEstacion,"producto_tres");
if ($GDiesel != "") :
$corteDiarioGeneral->validaFacturacion($idReporte, 'G DIESEL');
elseif ($idEstacion == 2) :
$corteDiarioGeneral->validaFacturacion($idReporte, 'Autolavado');
endif;
$corteDiarioGeneral->actualizarIngresoFacturacion($idReporte);
$corteDiarioGeneral->actualizarIF($idReporte);

//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$Estacion = "";
	   
}else{
$Estacion = ' ('.$datosEstacion['localidad'].')';
			
}

$sqlP1 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '" . $idReporte . "' AND posicion = 1";
$resultP1 = mysqli_query($con, $sqlP1);
$numeroP1 = mysqli_num_rows($resultP1);

$sqlP2 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '" . $idReporte . "' AND posicion = 2";
$resultP2 = mysqli_query($con, $sqlP2);
$numeroP2 = mysqli_num_rows($resultP2);
?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer">Ingresos VS Facturación</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$year?></li>
</ol>
</div>
       
<div class="row"> 
<div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Ingresos VS Facturación<?=$Estacion?>, <?=$year?></h3> </div>
<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end ms-2" onclick="Entregables(<?=$idReporte?>)">
<span class="btn-label2"><i class="fa-solid fa-file-pen"></i></span>Entregables</button>
</div>
</div>    
<hr>
</div>

<div class="table-responsive">
<table class="custom-table mt-2" style="font-size: .8em;" width="100%">

<thead class="title-table-bg">
<tr class="tables-bg">
<th colspan="14" class="align-middle text-center">Comparativo de Facturación</th>
</tr>

<tr>
<td class="align-middle text-center fw-bold">Cortes diarios</td>
<th class="align-middle text-end" width="120px">Enero</th>
<th class="align-middle text-end" width="120px">Febrero</th>
<th class="align-middle text-end" width="120px">Marzo</th>
<th class="align-middle text-end" width="120px">Abril</th>
<th class="align-middle text-end" width="120px">Mayo</th>
<th class="align-middle text-end" width="120px">Junio</th>
<th class="align-middle text-end" width="120px">Julio</th>
<th class="align-middle text-end" width="120px">Agosto</th>
<th class="align-middle text-end" width="120px">Septiembre</th>
<th class="align-middle text-end" width="120px">Octubre</th>
<th class="align-middle text-end" width="120px">Noviembre</th>
<th class="align-middle text-end" width="120px">Diciembre</th>
<td class="align-middle text-center fw-bold">Total Ejercicio</td>
</tr>
</thead>
		
<tbody class="bg-white">
	<?php
			$TCE1 = 0;
			$TCF1 = 0;
			$TCM1 = 0;
			$TCA1 = 0;
			$TCMY1 = 0;
			$TCJN1 = 0;
			$TCJL1 = 0;
			$TCAS1 = 0;
			$TCS1 = 0;
			$TCO1 = 0;
			$TCN1 = 0;
			$TCD1 = 0;
			$TCTEJ1 = 0;
			while ($rowP1 = mysqli_fetch_array($resultP1, MYSQLI_ASSOC)) {
				$id = $rowP1['id'];

				if ($rowP1['enero'] == 0) {
					$enero1 = "";
				} else {
					$enero1 = $rowP1['enero'];
				}

				if ($rowP1['febrero'] == 0) {
					$febrero1 = "";
				} else {
					$febrero1 = $rowP1['febrero'];
				}

				if ($rowP1['marzo'] == 0) {
					$marzo1 = "";
				} else {
					$marzo1 = $rowP1['marzo'];
				}

				if ($rowP1['abril'] == 0) {
					$abril1 = "";
				} else {
					$abril1 = $rowP1['abril'];
				}

				if ($rowP1['mayo'] == 0) {
					$mayo1 = "";
				} else {
					$mayo1 = $rowP1['mayo'];
				}

				if ($rowP1['junio'] == 0) {
					$junio1 = "";
				} else {
					$junio1 = $rowP1['junio'];
				}

				if ($rowP1['julio'] == 0) {
					$julio1 = "";
				} else {
					$julio1 = $rowP1['julio'];
				}

				if ($rowP1['agosto'] == 0) {
					$agosto1 = "";
				} else {
					$agosto1 = $rowP1['agosto'];
				}

				if ($rowP1['septiembre'] == 0) {
					$septiembre1 = "";
				} else {
					$septiembre1 = $rowP1['septiembre'];
				}

				if ($rowP1['octubre'] == 0) {
					$octubre1 = "";
				} else {
					$octubre1 = $rowP1['octubre'];
				}

				if ($rowP1['noviembre'] == 0) {
					$noviembre1 = "";
				} else {
					$noviembre1 = $rowP1['noviembre'];
				}

				if ($rowP1['diciembre'] == 0) {
					$diciembre1 = "";
				} else {
					$diciembre1 = $rowP1['diciembre'];
				}


				$totalEj1 = $rowP1['enero'] + $rowP1['febrero'] + $rowP1['marzo'] + $rowP1['abril'] + $rowP1['mayo'] + $rowP1['junio'] + $rowP1['julio'] + $rowP1['agosto'] + $rowP1['septiembre'] + $rowP1['octubre'] + $rowP1['noviembre'] + $rowP1['diciembre'];

				$TCE1 = $TCE1 + $rowP1['enero'];
				$TCF1 = $TCF1 + $rowP1['febrero'];
				$TCM1 = $TCM1 + $rowP1['marzo'];
				$TCA1 = $TCA1 + $rowP1['abril'];
				$TCMY1 = $TCMY1 + $rowP1['mayo'];
				$TCJN1 = $TCJN1 + $rowP1['junio'];
				$TCJL1 = $TCJL1 + $rowP1['julio'];
				$TCAS1 = $TCAS1 + $rowP1['agosto'];
				$TCS1 = $TCS1 + $rowP1['septiembre'];
				$TCO1 = $TCO1 + $rowP1['octubre'];
				$TCN1 = $TCN1 + $rowP1['noviembre'];
				$TCD1 = $TCD1 + $rowP1['diciembre'];

				$TCTEJ1 = $TCTEJ1 + $totalEj1;
				?>
				<tr>
					<th class="fw-normal"><?= $rowP1['detalle']; ?></th>
					<td class="align-middle p-0"><input id="D11<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $enero1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,1,1)"></td>
					<td class="align-middle p-0"><input id="D12<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $febrero1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,2,1)"></td>
					<td class="align-middle p-0"><input id="D13<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $marzo1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,3,1)"></td>
					<td class="align-middle p-0"><input id="D14<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $abril1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,4,1)"></td>
					<td class="align-middle p-0"><input id="D15<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $mayo1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,5,1)"></td>
					<td class="align-middle p-0"><input id="D16<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $junio1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,6,1)"></td>
					<td class="align-middle p-0"><input id="D17<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $julio1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,7,1)"></td>
					<td class="align-middle p-0"><input id="D18<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $agosto1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,8,1)"></td>
					<td class="align-middle p-0"><input id="D19<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $septiembre1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,9,1)"></td>
					<td class="align-middle p-0"><input id="D110<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $octubre1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,10,1)"></td>
					<td class="align-middle p-0"><input id="D111<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $noviembre1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,11,1)"></td>
					<td class="align-middle p-0"><input id="D112<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $diciembre1; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,12,1)"></td>
					<td class="align-middle text-end" id="TE1<?= $id; ?>">$ <?= number_format($totalEj1, 2); ?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<th class="align-middle">Total cortes diarios</td>
				<th class="align-middle text-end font-weight-bold" id="T11">$ <?= number_format($TCE1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T12">$ <?= number_format($TCF1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T13">$ <?= number_format($TCM1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T14">$ <?= number_format($TCA1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T15">$ <?= number_format($TCMY1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T16">$ <?= number_format($TCJN1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T17">$ <?= number_format($TCJL1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T18">$ <?= number_format($TCAS1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T19">$ <?= number_format($TCS1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T110">$ <?= number_format($TCO1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T111">$ <?= number_format($TCN1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="T112">$ <?= number_format($TCD1, 2); ?></th>
				<th class="align-middle text-end font-weight-bold" id="TF1">$ <?= number_format($TCTEJ1, 2); ?>
				</th>
			</tr>
		</tbody>
	</table>
</div>


<div class="table-responsive">
	<table class="custom-table mt-4" style="font-size: .8em;" width="100%">
	<thead class="title-table-bg">
	<tr class="tables-bg">
				<th colspan="14" class="align-middle text-center">Facturación</th>
			</tr>
			<tr>
				<td class="align-middle text-center fw-bold">Facturación</td>
				<th class="align-middle text-end" width="120px">Enero</th>
				<th class="align-middle text-end" width="120px">Febrero</th>
				<th class="align-middle text-end" width="120px">Marzo</th>
				<th class="align-middle text-end" width="120px">Abril</th>
				<th class="align-middle text-end" width="120px">Mayo</th>
				<th class="align-middle text-end" width="120px">Junio</th>
				<th class="align-middle text-end" width="120px">Julio</th>
				<th class="align-middle text-end" width="120px">Agosto</th>
				<th class="align-middle text-end" width="120px">Septiembre</th>
				<th class="align-middle text-end" width="120px">Octubre</th>
				<th class="align-middle text-end" width="120px">Noviembre</th>
				<th class="align-middle text-end" width="120px">Diciembre</th>
				<td class="align-middle text-end fw-bold">Total Ejercicio</td>
			</tr>
		</thead>
		<tbody class="bg-white">
			<?php
			$TCE2 = 0;
			$TCF2 = 0;
			$TCM2 = 0;
			$TCA2 = 0;
			$TCMY2 = 0;
			$TCJN2 = 0;
			$TCJL2 = 0;
			$TCAS2 = 0;
			$TCS2 = 0;
			$TCO2 = 0;
			$TCN2 = 0;
			$TCD2 = 0;
			$TCTEJ2 = 0;
			while ($rowP2 = mysqli_fetch_array($resultP2, MYSQLI_ASSOC)) {
				$id = $rowP2['id'];

				if ($rowP2['enero'] == 0) {
					$enero2 = "";
				} else {
					$enero2 = $rowP2['enero'];
				}

				if ($rowP2['febrero'] == 0) {
					$febrero2 = "";
				} else {
					$febrero2 = $rowP2['febrero'];
				}

				if ($rowP2['marzo'] == 0) {
					$marzo2 = "";
				} else {
					$marzo2 = $rowP2['marzo'];
				}

				if ($rowP2['abril'] == 0) {
					$abril2 = "";
				} else {
					$abril2 = $rowP2['abril'];
				}

				if ($rowP2['mayo'] == 0) {
					$mayo2 = "";
				} else {
					$mayo2 = $rowP2['mayo'];
				}

				if ($rowP2['junio'] == 0) {
					$junio2 = "";
				} else {
					$junio2 = $rowP2['junio'];
				}

				if ($rowP2['julio'] == 0) {
					$julio2 = "";
				} else {
					$julio2 = $rowP2['julio'];
				}

				if ($rowP2['agosto'] == 0) {
					$agosto2 = "";
				} else {
					$agosto2 = $rowP2['agosto'];
				}

				if ($rowP2['septiembre'] == 0) {
					$septiembre2 = "";
				} else {
					$septiembre2 = $rowP2['septiembre'];
				}

				if ($rowP2['octubre'] == 0) {
					$octubre2 = "";
				} else {
					$octubre2 = $rowP2['octubre'];
				}

				if ($rowP2['noviembre'] == 0) {
					$noviembre2 = "";
				} else {
					$noviembre2 = $rowP2['noviembre'];
				}

				if ($rowP2['diciembre'] == 0) {
					$diciembre2 = "";
				} else {
					$diciembre2 = $rowP2['diciembre'];
				}


				$totalEj2 = $rowP2['enero'] + $rowP2['febrero'] + $rowP2['marzo'] + $rowP2['abril'] + $rowP2['mayo'] + $rowP2['junio'] + $rowP2['julio'] + $rowP2['agosto'] + $rowP2['septiembre'] + $rowP2['octubre'] + $rowP2['noviembre'] + $rowP2['diciembre'];

				$TCE2 = $TCE2 + $rowP2['enero'];
				$TCF2 = $TCF2 + $rowP2['febrero'];
				$TCM2 = $TCM2 + $rowP2['marzo'];
				$TCA2 = $TCA2 + $rowP2['abril'];
				$TCMY2 = $TCMY2 + $rowP2['mayo'];
				$TCJN2 = $TCJN2 + $rowP2['junio'];
				$TCJL2 = $TCJL2 + $rowP2['julio'];
				$TCAS2 = $TCAS2 + $rowP2['agosto'];
				$TCS2 = $TCS2 + $rowP2['septiembre'];
				$TCO2 = $TCO2 + $rowP2['octubre'];
				$TCN2 = $TCN2 + $rowP2['noviembre'];
				$TCD2 = $TCD2 + $rowP2['diciembre'];

				$TCTEJ2 = $TCTEJ2 + $totalEj2;
				?>
				<tr>
					<th class="fw-normal"><?= $rowP2['detalle']; ?></th>
					<td class="align-middle p-0"><input id="D21<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $enero2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,1,2)"></td>
					<td class="align-middle p-0"><input id="D22<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $febrero2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,2,2)"></td>
					<td class="align-middle p-0"><input id="D23<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $marzo2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,3,2)"></td>
					<td class="align-middle p-0"><input id="D24<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $abril2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,4,2)"></td>
					<td class="align-middle p-0"><input id="D25<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $mayo2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,5,2)"></td>
					<td class="align-middle p-0"><input id="D26<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $junio2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,6,2)"></td>
					<td class="align-middle p-0"><input id="D27<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $julio2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,7,2)"></td>
					<td class="align-middle p-0"><input id="D28<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $agosto2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,8,2)"></td>
					<td class="align-middle p-0"><input id="D29<?= $id; ?>" class="form-control border-0 rounded-0 text-end"
							type="number" step="any" min="0" value="<?= $septiembre2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,9,2)"></td>
					<td class="align-middle p-0"><input id="D210<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $octubre2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,10,2)"></td>
					<td class="align-middle p-0"><input id="D211<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $noviembre2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,11,2)"></td>
					<td class="align-middle p-0"><input id="D212<?= $id; ?>"
							class="form-control border-0 rounded-0 text-end" type="number" step="any" min="0"
							value="<?= $diciembre2; ?>" style="font-size: .9em;"
							onkeyup="EditIF(<?= $idReporte; ?>,<?= $id; ?>,12,2)"></td>
					<td class="align-middle text-end" id="TE2<?= $id; ?>">$ <?= number_format($totalEj2, 2); ?></td>
				</tr>
				<?php
			}

			?>
			<tr>
				<th class="align-middle font-weight-bold">Total XML Timbrados</td>
				<th class="align-middle text-end font-weight-bold" id="T21">$ <?= number_format($TCE2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T22">$ <?= number_format($TCF2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T23">$ <?= number_format($TCM2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T24">$ <?= number_format($TCA2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T25">$ <?= number_format($TCMY2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T26">$ <?= number_format($TCJN2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T27">$ <?= number_format($TCJL2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T28">$ <?= number_format($TCAS2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T29">$ <?= number_format($TCS2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T210">$ <?= number_format($TCO2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T211">$ <?= number_format($TCN2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="T212">$ <?= number_format($TCD2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TF2">$ <?= number_format($TCTEJ2, 2); ?>
				</th>
			</tr>

			<?php

			$TD1 = $TCE2 - $TCE1;
			$TD2 = $TCF2 - $TCF1;
			$TD3 = $TCM2 - $TCM1;
			$TD4 = $TCA2 - $TCA1;
			$TD5 = $TCMY2 - $TCMY1;
			$TD6 = $TCJN2 - $TCJN1;
			$TD7 = $TCJL2 - $TCJL1;
			$TD8 = $TCAS2 - $TCAS1;
			$TD9 = $TCS2 - $TCS1;
			$TD10 = $TCO2 - $TCO1;
			$TD11 = $TCN2 - $TCN1;
			$TD12 = $TCD2 - $TCD1;
			$TDTE = $TCTEJ2 - $TCTEJ1;
			?>
			<tr>
				<th class="align-middle font-weight-bold">Total Diferencias</td>
				<th class="align-middle text-end font-weight-bold" id="TD1">$ <?= number_format($TD1, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD2">$ <?= number_format($TD2, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD3">$ <?= number_format($TD3, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD4">$ <?= number_format($TD4, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD5">$ <?= number_format($TD5, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD6">$ <?= number_format($TD6, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD7">$ <?= number_format($TD7, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD8">$ <?= number_format($TD8, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD9">$ <?= number_format($TD9, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD10">$ <?= number_format($TD10, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD11">$ <?= number_format($TD11, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TD12">$ <?= number_format($TD12, 2); ?>
				</th>
				<th class="align-middle text-end font-weight-bold" id="TDTE">$ <?= number_format($TDTE, 2); ?>
				</th>
			</tr>

		</tbody>
	</table>

</div>