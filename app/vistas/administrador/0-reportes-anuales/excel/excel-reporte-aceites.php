<?php
require '../../../../help.php';
require '../../../../lib/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

if ($idEstacion == 0) {
    $nombreES = 'General';
    $estaciones = [1, 2, 3, 4, 5, 6, 7, 14];
} else {
    $sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
    $result_estacion = mysqli_query($con, $sql_estacion);
    $row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC);
    $nombreES = $row_estacion ? $row_estacion['localidad'] : 'Desconocida';
    $estaciones = [$idEstacion];
}

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con) {
    $sql_year = "SELECT id FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
    $result_year = mysqli_query($con, $sql_year);
    $row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC);
    
    if ($row_year === null) return null;

    $idyear = $row_year['id'];

    $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
    $result_mes = mysqli_query($con, $sql_mes);
    $row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC);
    
    return $row_mes ? $row_mes['id'] : null;
}

function totalprecio($IdReporte, $noaceite, $con) {
    $total = 0;
    $cantidad = 0;
    $sql_listaaceite = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
        $id = $row_listaaceite['id'];

        $sql_listatotal = "SELECT cantidad, precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
        $result_listatotal = mysqli_query($con, $sql_listatotal);
        while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
            $cantidad += $row_listatotal['cantidad'] ?: 0;
            $precio = $row_listatotal['precio_unitario'] ?: 0;
            $total += $cantidad * $precio;
        }
    }
    return $total;
}

// Crear una nueva hoja de cálculo de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte Anual '.$year.'');

// Escribir los encabezados de las columnas en la primera fila
$arrayHead = [
    'No.', 'Estacion',
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
    'Total'
];

$sheet->fromArray($arrayHead, NULL, 'A1');

// Inicializar los totales mensuales
$totalesMensuales = array_fill(0, 12, 0);

$rowNum = 2;
foreach ($estaciones as $index => $estacion) {
    $datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($estacion);
    $nombreEstacion = $datosEstaciones['localidad'] ?: 'Desconocida';
    $sumaTotalEstacion = 0;
    
    $fila = [$index + 1, $nombreEstacion];

    foreach ($meses as $mes) {
        $IdReporte = IdReporte($estacion, $year, $mes, $con);
        $sumaTotalMes = 0;
        if ($IdReporte !== null) {
            $sql_listaaceites = "SELECT id_aceite FROM op_aceites_lubricantes_reporte WHERE id_mes = '$IdReporte' ORDER BY id_aceite ASC";
            $result_listaaceites = mysqli_query($con, $sql_listaaceites);
            while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
                $noaceite = $row_listaaceites['id_aceite'];
                $totalprecio = totalprecio($IdReporte, $noaceite, $con);
                $sumaTotalMes += $totalprecio;
            }
            $sumaTotalEstacion += $sumaTotalMes;
            $totalesMensuales[$mes - 1] += $sumaTotalMes;
        }
        $fila[] = $sumaTotalMes;
    }

    $fila[] = $sumaTotalEstacion;
    $sheet->fromArray($fila, 10, "A{$rowNum}");
    
    foreach (range('C', 'P') as $column) { 
        $sheet->getStyle("{$column}{$rowNum}")
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    }

    $rowNum++;
}


if($idEstacion == 0){
// Agregar la fila de totales mensuales, empezando en la celda B
$filaTotales = ['Total Neto'];
foreach ($totalesMensuales as $total) {
    $filaTotales[] = $total;
}

$filaTotales[] = array_sum($totalesMensuales);
// Escribir la fila de totales en la celda B (comenzando en la fila después de los datos)
$sheet->fromArray($filaTotales, 10, "B{$rowNum}");
$sheet->getStyle("B{$rowNum}:P{$rowNum}")->getFont()->setBold(true);
}


foreach (range('C', 'P') as $column) { 
    $sheet->getStyle("{$column}{$rowNum}")
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
}


// Configurar el formato de las columnas
$sheet->getStyle('P1')->getFont()->setBold(true);
foreach (range('A', 'P') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte Anual de Resumen de Aceites '.$nombreES.' - '.$year.'.xlsx"');
$writer->save('php://output');
