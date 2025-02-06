<?php 
error_reporting(error_level: 0);
require 'app/help.php';
require 'phpoffice/vendor/autoload.php'; 

$mesid = nombremes($GET_mes); 

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $GET_idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
$estacion = $row_listaestacion['nombre'];
}

function TarjetasCB($idReporte, $concepto, $con){
$baucher= 0;
$sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' AND concepto = '" . $concepto . "' LIMIT 1 ";
$result_cb = mysqli_query($con, $sql_cb);
while ($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)) {
$baucher = $row_cb['baucher'];
}
 
return $baucher;
}

function ProsegurImporte($idReporte, $denominacion, $con){
$importe2 = 0;
$sql_listaprosegur2 = "SELECT importe FROM op_prosegur WHERE idreporte_dia = '" . $idReporte . "' AND denominacion = '" . $denominacion . "' LIMIT 1 ";
$result_listaprosegur2 = mysqli_query($con, $sql_listaprosegur2);
$numero_listaprosegur2 = mysqli_num_rows($result_listaprosegur2);
while ($row_listaprosegur2 = mysqli_fetch_array($result_listaprosegur2, MYSQLI_ASSOC)) {
$importe2 = $row_listaprosegur2['importe'];

}

return $importe2;
}


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();

// ---------- PAGINA 1 ----------//
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle("Resumen Monedero");

// ---------- FILA 1 ----------
$sheet1->setCellValue('A1', 'MONEDEROS');
$sheet1->mergeCells('A1:R1');  // Combina las celdas
$sheet1->setCellValue('S1', 'CRÉDITO');
$sheet1->mergeCells('S1:T1');  // Combina las celdas
$sheet1->setCellValue('U1', 'DÉBITO');
$sheet1->mergeCells('U1:V1');  // Combina las celdas
$sheet1->setCellValue('W1', 'PAGOS');
$sheet1->setCellValue('X1', 'CONSUMOS');

$sheet1->getStyle('A1:X1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A1:X1')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A1:X1')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

if($session_nompuesto != "Encargado"){
$sheet1->setCellValue('Y1', '');
$sheet1->mergeCells('Y1:AH1');  // Combina las celdas
$sheet1->getStyle('A1:AH1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A1:AH1')->getFill()->getStartColor()->setRGB('215d98');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A1:AH1')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco
}

// ---------- FILA 2 ----------
$sheet1->setCellValue('A2', '');
$sheet1->setCellValue('B2', 'TARJETAS BANCARIAS');
$sheet1->mergeCells('B2:E2');  // Combina las celdas
$sheet1->setCellValue('F2', 'TARJETAS');
$sheet1->mergeCells('F2:M2');  // Combina las celdas
$sheet1->setCellValue('N2', 'VALES');
$sheet1->mergeCells('N2:R2');  // Combina las celdas
$sheet1->setCellValue('S2', 'CARTERA DE CLIENTES ATIO');
$sheet1->mergeCells('S2:X2');  // Combina las celdas

$sheet1->getStyle('A2:X2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A2:X2')->getFill()->getStartColor()->setRGB('749ABF');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A2:X2')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

if($session_nompuesto != "Encargado"){
$sheet1->setCellValue('Y2', 'PROSEGUR');
$sheet1->mergeCells('Y2:AH2');  // Combina las celdas
$sheet1->getStyle('A2:AH2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A2:AH2')->getFill()->getStartColor()->setRGB('749ABF');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A2:AH2')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco
}


// ---------- FILA 3 ----------
$sheet1->setCellValue('A3', 'FECHA');
$sheet1->setCellValue('B3', 'BANCOMER');
$sheet1->setCellValue('C3', 'AMEX');
$sheet1->setCellValue('D3', 'INBURSA');
$sheet1->setCellValue('E3', 'TOTAL');

$sheet1->setCellValue('F3', 'INBURGAS');
$sheet1->setCellValue('G3', 'EDENRED');
$sheet1->setCellValue('H3', 'EFECTIVALE');
$sheet1->setCellValue('I3', 'SODEXO');
$sheet1->setCellValue('J3', 'ULTRAGAS');
$sheet1->setCellValue('K3', 'ENERGEX');
$sheet1->setCellValue('L3', 'SHELL');
$sheet1->setCellValue('M3', 'TOTAL');

$sheet1->setCellValue('N3', 'VALE ACCORD');
$sheet1->setCellValue('O3', 'VALE EFECTIVALE');
$sheet1->setCellValue('P3', 'VALE SODEXO');
$sheet1->setCellValue('Q3', 'SI VALE');
$sheet1->setCellValue('R3', 'TOTAL');

$sheet1->setCellValue('S3', 'PAGOS');
$sheet1->setCellValue('T3', 'CONSUMOS');
$sheet1->setCellValue('U3', 'PAGOS');
$sheet1->setCellValue('V3', 'CONSUMOS');
$sheet1->setCellValue('W3', 'TOTAL');
$sheet1->setCellValue('X3', 'TOTAL');

if($session_nompuesto != "Encargado"){
$sheet1->setCellValue('Y3', 'BILLETE MATUTINO');
$sheet1->setCellValue('Z3', 'BILLETE VESPERTINO');
$sheet1->setCellValue('AA3', 'BILLETE NOCTURNO');
$sheet1->setCellValue('AB3', 'MORRALLA');
$sheet1->setCellValue('AC3', 'DEPOSITO BANCARIO');
$sheet1->setCellValue('AD3', 'CHEQUE 1');
$sheet1->setCellValue('AE3', 'TRANSFERENCIA 1');
$sheet1->setCellValue('AF3', 'CHEQUE 2');
$sheet1->setCellValue('AG3', 'TRANSFERENCIA 2');
$sheet1->setCellValue('AH3', 'TOTAL');
}

// ---------- FILA 4 ----------
$rowIndexArea = 4;
$sql_listadia = "
SELECT 
op_corte_year.id_estacion,
op_corte_year.year,
op_corte_mes.mes,
op_corte_dia.id AS idDia,
op_corte_dia.fecha
FROM op_corte_year
INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
WHERE op_corte_year.id_estacion = '" . $GET_idEstacion . "' AND 
op_corte_year.year = '" . $GET_year . "' AND 
op_corte_mes.mes = '" . $GET_mes . "'";
$result_listadia = mysqli_query($con, $sql_listadia);
$numero_listadia = mysqli_num_rows($result_listadia);

while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
$idDias = $row_listadia['idDia'];
$fecha = $row_listadia['fecha'];

$bancomer = TarjetasCB($idDias, "BBVA BANCOMER SA", $con);
$amex = TarjetasCB($idDias, "AMERICAN EXPRESS", $con);
$inbursa = TarjetasCB($idDias, "INBURSA", $con);
$totalTB = $bancomer + $amex + $inbursa;

$Tobancomer = $Tobancomer + $bancomer;
$Toamex = $Toamex + $amex;
$Toinbursa = $Toinbursa + $inbursa;
$TototalTB = $TototalTB + $totalTB;


$sheet1->setCellValue("A$rowIndexArea", FormatoFecha($fecha));
$sheet1->setCellValue("B$rowIndexArea", $bancomer);
$sheet1->setCellValue("C$rowIndexArea", $amex);
$sheet1->setCellValue("D$rowIndexArea", $inbursa);
$sheet1->setCellValue("E$rowIndexArea", $totalTB);

$inburgas = TarjetasCB($idDias, "INBURGAS", $con);
$edenred = TarjetasCB($idDias, "TICKETCARD", $con);
$efecticard = TarjetasCB($idDias, "EFECTICARD", $con);
$sodexo = TarjetasCB($idDias, "SODEXO", $con);
$ultragas = TarjetasCB($idDias, "ULTRAGAS", $con);
$energex = TarjetasCB($idDias, "ENERGEX", $con);
$shell = TarjetasCB($idDias, "SHELL FLEET NAVIGATOR", $con);
$totalTarjetas = $inburgas + $edenred + $efecticard + $sodexo + $ultragas + $energex + $shell;

$Toinburgas = $Toinburgas + $inburgas;
$Toedenred = $Toedenred + $edenred;
$Toefecticard = $Toefecticard + $efecticard;
$Tosodexo = $Tosodexo + $sodexo;
$Toultragas = $Toultragas + $ultragas;
$Toenergex = $Toenergex + $energex;
$Toshell = $Toshell + $shell;
$TototalTarjetas = $TototalTarjetas + $totalTarjetas;

$sheet1->setCellValue("F$rowIndexArea", $inburgas);
$sheet1->setCellValue("G$rowIndexArea", $edenred);
$sheet1->setCellValue("H$rowIndexArea", $efecticard);
$sheet1->setCellValue("I$rowIndexArea", $sodexo);
$sheet1->setCellValue("J$rowIndexArea", $ultragas);
$sheet1->setCellValue("K$rowIndexArea", $energex);
$sheet1->setCellValue("L$rowIndexArea", $shell);
$sheet1->setCellValue("M$rowIndexArea", $totalTarjetas);

$valaccord = TarjetasCB($idDias, "VALE ACCORD", $con);
$valefectivale = TarjetasCB($idDias, "VALE EFECTIVALE", $con);
$valsodexo = TarjetasCB($idDias, "VALE SODEXO", $con);
$valvale = TarjetasCB($idDias, "SI VALE", $con);
$totalVales = $valaccord + $valefectivale + $valsodexo + $valvale;

$Tovalaccord = $Tovalaccord + $valaccord;
$Tovalefectivale = $Tovalefectivale + $valefectivale;
$Tovalsodexo = $Tovalsodexo + $valsodexo;
$Tovalvale = $Tovalvale + $valvale;
$GTVales = $GTVales + $totalVales;

$sheet1->setCellValue("N$rowIndexArea", $valaccord);
$sheet1->setCellValue("O$rowIndexArea", $valefectivale);
$sheet1->setCellValue("P$rowIndexArea", $valsodexo);
$sheet1->setCellValue("Q$rowIndexArea", $valvale);
$sheet1->setCellValue("R$rowIndexArea", $totalVales);

$sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $idDias . "' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
$result_CCPC = mysqli_query($con, $sql_CCPC);
$numero_CCPC = mysqli_num_rows($result_CCPC);
if ($numero_CCPC == 1) {
while ($row_CCPC = mysqli_fetch_array($result_CCPC, MYSQLI_ASSOC)) {
$pagoC = $row_CCPC['pago'];
$consumoC = $row_CCPC['consumo'];
}
} else {
$pagoC = 0;
$consumoC = 0;
}

$sql_CDPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $idDias . "' AND concepto = 'DEBITO (ANEXO)' LIMIT 1 ";
$result_CDPC = mysqli_query($con, $sql_CDPC);
$numero_CDPC = mysqli_num_rows($result_CDPC);
if ($numero_CDPC == 1) {
while ($row_CDPC = mysqli_fetch_array($result_CDPC, MYSQLI_ASSOC)) {
$pagoD = $row_CDPC['pago'];
$consumoD = $row_CDPC['consumo'];
}
} else {
$pagoD = 0;
$consumoD = 0;
}



$TopagoC = $TopagoC + $pagoC;
$ToconsumoC = $ToconsumoC + $consumoC;
$TopagoD = $TopagoD + $pagoD;
$ToconsumoD = $ToconsumoD + $consumoD;

$totalPago = $pagoC + $pagoD;
$totalConsumo = $consumoC + $consumoD;

$TototalPago = $TototalPago + $totalPago;
$TototalConsumo = $TototalConsumo + $totalConsumo;

$sheet1->setCellValue("S$rowIndexArea", $pagoC);
$sheet1->setCellValue("T$rowIndexArea", $consumoC);
$sheet1->setCellValue("U$rowIndexArea", $pagoD);
$sheet1->setCellValue("V$rowIndexArea", $consumoD);
$sheet1->setCellValue("W$rowIndexArea", $totalPago);
$sheet1->setCellValue("X$rowIndexArea", $totalConsumo);

$BilleteMatutino = ProsegurImporte($idDias, "BILLETE MATUTINO", $con);
$BilleteVespertino = ProsegurImporte($idDias, "BILLETE VESPERTINO", $con);
$BilleteNocturno = ProsegurImporte($idDias, "BILLETE NOCTURNO", $con);
$Morralla = ProsegurImporte($idDias, "MORRALLA", $con);
$DespositoBancario = ProsegurImporte($idDias, "DEPOSITO BANCARIO", $con);
$Cheque1 = ProsegurImporte($idDias, "CHEQUE 1", $con);
$Transferencia1 = ProsegurImporte($idDias, "TRANSFERENCIA 1", $con);
$Cheque2 = ProsegurImporte($idDias, "CHEQUE 2", $con);
$Transferencia2 = ProsegurImporte($idDias, "TRANSFERENCIA 2", $con);
$totalImporte = $BilleteMatutino + $BilleteVespertino + $BilleteNocturno + $Morralla + $DespositoBancario + $Cheque1 + $Transferencia1 + $Cheque2 + $Transferencia2;

$ToBilleteM = $ToBilleteM + $BilleteMatutino;
$ToBilleteV = $ToBilleteV + $BilleteVespertino;
$ToBilleteN = $ToBilleteN + $BilleteNocturno;
$ToMorralla = $ToMorralla + $Morralla;
$ToDesposito = $ToDesposito + $DespositoBancario;
$ToCheque1 = $ToCheque1 + $Cheque1;
$ToTransferencia1 = $ToTransferencia1 + $Transferencia1;
$ToCheque2 = $ToCheque2 + $Cheque2;
$ToTransferencia2 = $ToTransferencia2 + $Transferencia2;
$Toprosegur = $Toprosegur + $totalImporte;

if($session_nompuesto != "Encargado"){
$sheet1->setCellValue("Y$rowIndexArea", $BilleteMatutino);
$sheet1->setCellValue("Z$rowIndexArea", $BilleteVespertino);
$sheet1->setCellValue("AA$rowIndexArea", $BilleteNocturno);
$sheet1->setCellValue("AB$rowIndexArea", $Morralla);
$sheet1->setCellValue("AC$rowIndexArea", $DespositoBancario);
$sheet1->setCellValue("AD$rowIndexArea", $Cheque1);
$sheet1->setCellValue("AE$rowIndexArea", $Transferencia1);
$sheet1->setCellValue("AF$rowIndexArea", $Cheque2);
$sheet1->setCellValue("AG$rowIndexArea", $Transferencia2);
$sheet1->setCellValue("AH$rowIndexArea", $totalImporte);
}

$rowIndexArea++;
}

$rowTotal = $rowIndexArea + 1;

// ---------- FILA TOTALES ----------
$sheet1->setCellValue("A$rowIndexArea", '');
$sheet1->setCellValue("B$rowIndexArea", $Tobancomer);
$sheet1->setCellValue("C$rowIndexArea", $Toamex);
$sheet1->setCellValue("D$rowIndexArea", $Toinbursa);
$sheet1->setCellValue("E$rowIndexArea", $TototalTB);

$sheet1->setCellValue("F$rowIndexArea", $Toinburgas);
$sheet1->setCellValue("G$rowIndexArea", $Toedenred);
$sheet1->setCellValue("H$rowIndexArea", $Toefecticard);
$sheet1->setCellValue("I$rowIndexArea", $Tosodexo);
$sheet1->setCellValue("J$rowIndexArea", $Toultragas);
$sheet1->setCellValue("K$rowIndexArea", $Toenergex);
$sheet1->setCellValue("L$rowIndexArea", $Toshell);
$sheet1->setCellValue("M$rowIndexArea", $TototalTarjetas);

$sheet1->setCellValue("N$rowIndexArea", $Tovalaccord);
$sheet1->setCellValue("O$rowIndexArea", $Tovalefectivale);
$sheet1->setCellValue("P$rowIndexArea", $Tovalsodexo);
$sheet1->setCellValue("Q$rowIndexArea", $Tovalvale);
$sheet1->setCellValue("R$rowIndexArea", $GTVales);

$sheet1->setCellValue("S$rowIndexArea", $TopagoC);
$sheet1->setCellValue("T$rowIndexArea", $ToconsumoC);
$sheet1->setCellValue("U$rowIndexArea", $TopagoD);
$sheet1->setCellValue("V$rowIndexArea", $ToconsumoD);
$sheet1->setCellValue("W$rowIndexArea", $TototalPago);
$sheet1->setCellValue("X$rowIndexArea", $TototalConsumo);

if($session_nompuesto != "Encargado"){
$sheet1->setCellValue("Y$rowIndexArea", $ToBilleteM);
$sheet1->setCellValue("Z$rowIndexArea", $ToBilleteV);
$sheet1->setCellValue("AA$rowIndexArea", $ToBilleteN);
$sheet1->setCellValue("AB$rowIndexArea", $ToMorralla);
$sheet1->setCellValue("AC$rowIndexArea", $ToDesposito);
$sheet1->setCellValue("AD$rowIndexArea", $ToCheque1);
$sheet1->setCellValue("AE$rowIndexArea", $ToTransferencia1);
$sheet1->setCellValue("AF$rowIndexArea",  $ToCheque2);
$sheet1->setCellValue("AG$rowIndexArea", $ToTransferencia2);
$sheet1->setCellValue("AH$rowIndexArea", $Toprosegur);
}

// Ajustar el ancho de las columnas automáticamente
$sheet1->getColumnDimension('A')->setAutoSize(true); 
$sheet1->getColumnDimension('B')->setAutoSize(true); 
$sheet1->getColumnDimension('C')->setAutoSize(true); 
$sheet1->getColumnDimension('D')->setAutoSize(true); 
$sheet1->getColumnDimension('E')->setAutoSize(true); 
$sheet1->getColumnDimension('F')->setAutoSize(true); 
$sheet1->getColumnDimension('G')->setAutoSize(true); 
$sheet1->getColumnDimension('H')->setAutoSize(true); 
$sheet1->getColumnDimension('I')->setAutoSize(true); 
$sheet1->getColumnDimension('J')->setAutoSize(true); 
$sheet1->getColumnDimension('K')->setAutoSize(true); 
$sheet1->getColumnDimension('L')->setAutoSize(true); 
$sheet1->getColumnDimension('M')->setAutoSize(true); 
$sheet1->getColumnDimension('N')->setAutoSize(true); 
$sheet1->getColumnDimension('O')->setAutoSize(true); 
$sheet1->getColumnDimension('P')->setAutoSize(true); 
$sheet1->getColumnDimension('Q')->setAutoSize(true); 
$sheet1->getColumnDimension('R')->setAutoSize(true); 
$sheet1->getColumnDimension('S')->setAutoSize(true); 
$sheet1->getColumnDimension('T')->setAutoSize(true); 
$sheet1->getColumnDimension('U')->setAutoSize(true); 
$sheet1->getColumnDimension('V')->setAutoSize(true); 
$sheet1->getColumnDimension('W')->setAutoSize(true); 
$sheet1->getColumnDimension('X')->setAutoSize(true); 

if($session_nompuesto != "Encargado"){
$sheet1->getColumnDimension('Y')->setAutoSize(true); 
$sheet1->getColumnDimension('Z')->setAutoSize(true); 
$sheet1->getColumnDimension('AA')->setAutoSize(true); 
$sheet1->getColumnDimension('AB')->setAutoSize(true); 
$sheet1->getColumnDimension('AC')->setAutoSize(true); 
$sheet1->getColumnDimension('AD')->setAutoSize(true); 
$sheet1->getColumnDimension('AE')->setAutoSize(true); 
$sheet1->getColumnDimension('AF')->setAutoSize(true); 
$sheet1->getColumnDimension('AG')->setAutoSize(true); 
$sheet1->getColumnDimension('AH')->setAutoSize(true); 
}

// Guardar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Resumen_Monedero_'.$estacion.'_'.$mesid.'_'.$GET_year.'.xlsx"');
$writer->save('php://output');
exit;
