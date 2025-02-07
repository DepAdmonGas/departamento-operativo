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

function IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con){
$sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $GET_idEstacion . "' AND year = '" . $GET_year . "' ";
$result_year = mysqli_query($con, $sql_year);
while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
$idyear = $row_year['id'];
}

$sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
$result_mes = mysqli_query($con, $sql_mes);
while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
$idmes = $row_mes['id'];
}
return $idmes;
}

$IdReporte = IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();

// ---------- PAGINA 1 ----------//
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle("Credito");

// ---------- Encabezado 1 ----------
$sheet1->setCellValue('A1', '#');
$sheet1->setCellValue('B1', 'CUENTA');
$sheet1->setCellValue('C1', 'CLIENTE');
$sheet1->setCellValue('D1', 'SALDO INICIO');
$sheet1->setCellValue('E1', 'CONSUMOS');
$sheet1->setCellValue('F1', 'PAGOS');
$sheet1->setCellValue('G1', 'SALDO FINAL');

$sheet1->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet1->getStyle('A1:G1')->getFill()->getStartColor()->setRGB('749ABF');  // Establece el color de fondo a azul (#0000FF)
$sheet1->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

//---------- FILA 2 (CONTENIDO) ----------
$sql_credito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Crédito' AND op_cliente.estado = 1 ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

$rowtbCredito = 2;

$Csaldoinicial = 0;
$Cconsumos = 0;
$Cpagos = 0;
$CSaFi = 0;
$TSIC = 0;
$TCC = 0;
$TPC = 0;
$TSFC = 0;

if ($numero_credito > 0) {
while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {
$id = $row_credito['id'];
$cuentaC = $row_credito['cuenta'];
$clienteC = $row_credito['cliente'];
$saldoInicial = $row_credito['saldo_inicial'];
$consumos = $row_credito['consumos'];
$pagos = $row_credito['pagos'];

$saldofinalC = $row_credito['saldo_inicial'] + $row_credito['consumos'] - $row_credito['pagos'];
$Csaldoinicial = $Csaldoinicial + $row_credito['saldo_inicial'];
$Cconsumos = $Cconsumos + $row_credito['consumos'];
$Cpagos = $Cpagos + $row_credito['pagos'];
$CSaFi = $CSaFi + $saldofinalC;

$TSIC = $TSIC + $row_credito['saldo_inicial'];
$TCC = $TCC + $row_credito['consumos'];
$TPC = $TPC + $row_credito['pagos'];
$TSFC = $TSFC + $row_credito['saldo_final'];

$sheet1->setCellValue("A$rowtbCredito", $id);
$sheet1->setCellValue("B$rowtbCredito", $cuentaC);
$sheet1->setCellValue("C$rowtbCredito", $clienteC);
$sheet1->setCellValue("D$rowtbCredito", $saldoInicial);
$sheet1->setCellValue("E$rowtbCredito", $consumos);
$sheet1->setCellValue("F$rowtbCredito", $pagos);
$sheet1->setCellValue("G$rowtbCredito", $saldofinalC);

$rowtbCredito++;
}
}else{
$sheet1->setCellValue("A$rowtbCredito", "No se encontro informacion.");
$sheet1->mergeCells("A$rowtbCredito:G$rowtbCredito");  // Combina las celdas
}

$rowtbCredito2 = $rowtbCredito + 1;

$sheet1->setCellValue("A$rowtbCredito2", "TOTAL CREDITO");
$sheet1->mergeCells("A$rowtbCredito2:C$rowtbCredito2");  // Combina las celdas
$sheet1->setCellValue("D$rowtbCredito2", $TSIC);
$sheet1->setCellValue("E$rowtbCredito2", $TCC);
$sheet1->setCellValue("F$rowtbCredito2", $TPC);
$sheet1->setCellValue("G$rowtbCredito2", $TSFC);

// Ajustar el ancho de las columnas automáticamente
$sheet1->getColumnDimension('A')->setAutoSize(true); 
$sheet1->getColumnDimension('B')->setAutoSize(true); 
$sheet1->getColumnDimension('C')->setAutoSize(true); 
$sheet1->getColumnDimension('D')->setAutoSize(true); 
$sheet1->getColumnDimension('E')->setAutoSize(true); 
$sheet1->getColumnDimension('F')->setAutoSize(true); 
$sheet1->getColumnDimension('G')->setAutoSize(true); 

$sheet1->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('D')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('E')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('F')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet1->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet1->getStyle('G')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente

// ---------- PAGINA 2 ----------//
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle("Debito");

// ---------- Encabezado 1 ----------
$sheet2->setCellValue('A1', '#');
$sheet2->setCellValue('B1', 'CUENTA');
$sheet2->setCellValue('C1', 'CLIENTE');
$sheet2->setCellValue('D1', 'SALDO INICIO');
$sheet2->setCellValue('E1', 'CONSUMOS');
$sheet2->setCellValue('F1', 'PAGOS');
$sheet2->setCellValue('G1', 'SALDO FINAL');

$sheet2->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet2->getStyle('A1:G1')->getFill()->getStartColor()->setRGB('749ABF');  // Establece el color de fondo a azul (#0000FF)
$sheet2->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

//---------- FILA 2 (CONTENIDO) ----------
$sql_debito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Débito' AND op_cliente.estado = 1 ";
$result_debito = mysqli_query($con, $sql_debito);
$numero_debito = mysqli_num_rows($result_debito);
$rowtbDebito = 2;

$Dsaldoinicial = 0;
$Dconsumos = 0;
$Dpagos = 0;
$DSaFi = 0;
$TSID = 0;
$TCD = 0;
$TPD = 0;
$TSFD = 0;

if ($numero_debito > 0) {
while ($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)) {
$id = $row_debito['id'];
$cuentaC = $row_debito['cuenta'];
$clienteC = $row_debito['cliente'];
$saldoInicial = $row_debito['saldo_inicial'];
$consumos = $row_debito['consumos'];
$pagos = $row_debito['pagos'];

$saldofinalD = $row_debito['saldo_inicial'] + $row_debito['consumos'] - $row_debito['pagos'];
$Dsaldoinicial = $Dsaldoinicial + $row_debito['saldo_inicial'];
$Dconsumos = $Dconsumos + $row_debito['consumos'];
$Dpagos = $Dpagos + $row_debito['pagos'];
$DSaFi = $DSaFi + $saldofinalD;

$TSID = $TSID + $row_debito['saldo_inicial'];
$TCD = $TCD + $row_debito['consumos'];
$TPD = $TPD + $row_debito['pagos'];
$TSFD = $TSFD + $row_debito['saldo_final'];

$sheet2->setCellValue("A$rowtbDebito", $id);
$sheet2->setCellValue("B$rowtbDebito", $cuentaC);
$sheet2->setCellValue("C$rowtbDebito", $clienteC);
$sheet2->setCellValue("D$rowtbDebito", $saldoInicial);
$sheet2->setCellValue("E$rowtbDebito", $consumos);
$sheet2->setCellValue("F$rowtbDebito", $pagos);
$sheet2->setCellValue("G$rowtbDebito", $saldofinalD);

$rowtbDebito++;
}
}else{
$sheet2->setCellValue("A$rowtbDebito", "No se encontro informacion.");
$sheet2->mergeCells("A$rowtbDebito:G$rowtbDebito");  // Combina las celdas
}

$rowtbDebito2 = $rowtbDebito + 1;

$sheet2->setCellValue("A$rowtbDebito2", "TOTAL DEBITO");
$sheet2->mergeCells("A$rowtbDebito2:C$rowtbDebito2");  // Combina las celdas
$sheet2->setCellValue("D$rowtbDebito2", $TSID);
$sheet2->setCellValue("E$rowtbDebito2", $TCD);
$sheet2->setCellValue("F$rowtbDebito2", $TPD);
$sheet2->setCellValue("G$rowtbDebito2", $TSFD);

// Ajustar el ancho de las columnas automáticamente
$sheet2->getColumnDimension('A')->setAutoSize(true); 
$sheet2->getColumnDimension('B')->setAutoSize(true); 
$sheet2->getColumnDimension('C')->setAutoSize(true); 
$sheet2->getColumnDimension('D')->setAutoSize(true); 
$sheet2->getColumnDimension('E')->setAutoSize(true); 
$sheet2->getColumnDimension('F')->setAutoSize(true); 
$sheet2->getColumnDimension('G')->setAutoSize(true); 

$sheet2->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet2->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet2->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('D')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet2->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('E')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet2->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('F')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet2->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet2->getStyle('G')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente

// ---------- PAGINA 2 ----------//
$sheet3 = $spreadsheet->createSheet();
$sheet3->setTitle("Gran total");

$sheet3->setCellValue('A1', '');
$sheet3->setCellValue('B1', 'SALDO INICIO');
$sheet3->setCellValue('C1', 'CONSUMOS');
$sheet3->setCellValue('D1', 'PAGOS');
$sheet3->setCellValue('E1', 'SALDO FINAL');

$sheet3->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);  // Establece el tipo de relleno sólido
$sheet3->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('749ABF');  // Establece el color de fondo a azul (#0000FF)
$sheet3->getStyle('A1:E1')->getFont()->getColor()->setRGB('FFFFFF');  // Establece el color del texto a blanco

$sheet3->setCellValue('A2', 'CREDITO');
$sheet3->setCellValue('B2', $TSIC);
$sheet3->setCellValue('C2', $TCC);
$sheet3->setCellValue("D2", $TPC);
$sheet3->setCellValue("E2", $TSFC);

$sheet3->setCellValue('A3', 'DEBITO');
$sheet3->setCellValue('B3', $TSID);
$sheet3->setCellValue('C3', $TCD);
$sheet3->setCellValue("D3", $TPD);
$sheet3->setCellValue("E3", $TSFD);

$sheet3->setCellValue('A4', 'TOTAL');
$sheet3->setCellValue('B4', $TSIC + $TSID);
$sheet3->setCellValue('C4', $TCC + $TCD);
$sheet3->setCellValue("D4", $TPC + $TPD);
$sheet3->setCellValue("E4", $TSFC + $TSFD);

// Ajustar el ancho de las columnas automáticamente
$sheet3->getColumnDimension('A')->setAutoSize(true); 
$sheet3->getColumnDimension('B')->setAutoSize(true); 
$sheet3->getColumnDimension('C')->setAutoSize(true); 
$sheet3->getColumnDimension('D')->setAutoSize(true); 
$sheet3->getColumnDimension('E')->setAutoSize(true); 

$sheet3->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet3->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet3->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet3->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet3->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet3->getStyle('C')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet3->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet3->getStyle('D')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente
$sheet3->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  // Centra el texto horizontalmente
$sheet3->getStyle('E')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);  // Centra el texto verticalmente



// Guardar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Resumen_Clientes_'.$estacion.'_'.$mesid.'_'.$GET_year.'.xlsx"');
$writer->save('php://output');
exit;


