<?php
require ('../../../../../app/help.php');
require ('../../../../../app/lib/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
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
    while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $nombreES = $row_estacion['localidad'];
    }
    $estaciones = [$idEstacion];
} 

function TotalVentas($idDias, $Producto, $con)
{
    $sql = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idDias . "' AND producto = '" . $Producto . "'";
    $result = mysqli_query($con, $sql);
    $TotalLitros = 0;
    $TotalPrecio = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $litros = $row['litros'];
        $preciolitro = $row['precio_litro'];
        $LitrosPrecio = $litros * $preciolitro;

        $TotalLitros += $litros;
        $TotalPrecio += $LitrosPrecio;
    }

    return array(
        'TotalLitros' => $TotalLitros,
        'TotalPrecio' => $TotalPrecio
    );
}

function generarHojaPorTipo($spreadsheet, $estaciones, $meses, $year, $producto, $tipo, $con, $ClassHerramientasDptoOperativo) {
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($producto . " - " . ucfirst($tipo));

    // Escribir encabezados de columnas
    $row = 1;
    $sheet->setCellValue('A1', 'Estacion');
    $col = 2;
    foreach ($meses as $mes) {
        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row;
        $sheet->setCellValue($cellCoordinate, nombremes($mes));
        $sheet->getStyle($cellCoordinate)->getAlignment()->setWrapText(true);
        if ($tipo == 'litros') {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
        } else {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        }
    }

    // Encabezado "Total"
    $cellCoordinateTotal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row;
    $sheet->setCellValue($cellCoordinateTotal, "Total (" . ucfirst($tipo) . ")");
    $sheet->getStyle($cellCoordinateTotal)->getAlignment()->setWrapText(true);

    // Aplicar negrita al encabezado "Total"
    $sheet->getStyle($cellCoordinateTotal)->getFont()->setBold(true);

    $rowNum = 2;
    $totalesPorMes = array_fill(0, count($meses), 0); // Inicializar arreglo para totales por mes

    foreach ($estaciones as $estacion) {
        // Usar la función obtenerDatosLocalidades
        $datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($estacion);
        $nombreEstacion = $datosEstaciones['localidad'];

        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1) . $rowNum, $nombreEstacion);

        $sumaTotal = 0;
        $colNum = 2;

        foreach ($meses as $index => $mes) {
            $P1T = 0;

            $sql_listadia = "
            SELECT op_corte_dia.id AS idDia
            FROM op_corte_year
            INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
            INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
            WHERE op_corte_year.id_estacion = '" . $estacion . "' 
            AND op_corte_year.year =  '".$year."'
            AND op_corte_mes.mes = '" . $mes . "'";

            $result_listadia = mysqli_query($con, $sql_listadia);

            while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
                $idDias = $row_listadia['idDia'];
                $Producto1 = TotalVentas($idDias, $producto, $con);

                if ($tipo == 'litros') {
                    $P1T += $Producto1['TotalLitros'];
                } else {
                    $P1T += $Producto1['TotalPrecio'];
                }
            }

            // Asignar valores numéricos
            $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
            $sheet->setCellValueExplicit($cellCoordinate, $P1T, DataType::TYPE_NUMERIC);
            if ($tipo == 'litros') {
                $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
            } else {
                $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            }

            $sumaTotal += $P1T;
            $totalesPorMes[$index] += $P1T; // Sumar al total mensual
        }

        // Añadir las sumas totales por estación
        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum) . $rowNum;
        $sheet->setCellValueExplicit($cellCoordinate, $sumaTotal, DataType::TYPE_NUMERIC);
        if ($tipo == 'litros') {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
        } else {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        }

        // Aplicar negrita a la suma total por estación
        $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);

        $rowNum++;
    }

    // Añadir fila con los totales por mes
    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1) . $rowNum, 'Total Neto');
    $colNum = 2;

    foreach ($totalesPorMes as $total) {
        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
        $sheet->setCellValueExplicit($cellCoordinate, $total, DataType::TYPE_NUMERIC);
        if ($tipo == 'litros') {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
        } else {
            $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        }

        $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);
    }

    // Añadir total general (suma de todos los totales por estación)
    $totalGeneral = array_sum($totalesPorMes);
    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum) . $rowNum;
    $sheet->setCellValueExplicit($cellCoordinate, $totalGeneral, DataType::TYPE_NUMERIC);
    if ($tipo == 'litros') {
        $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00');
    } else {
        $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    }

    $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);

    // Ajustar el ancho de las columnas automáticamente
    foreach (range('A', \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col)) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
}


// Inicializa $spreadsheet y $productos
$spreadsheet = new Spreadsheet();
$productos = ['G SUPER', 'G PREMIUM', 'G DIESEL'];

// Generar hojas
foreach ($productos as $producto) {
    generarHojaPorTipo($spreadsheet, $estaciones, $meses, $year, $producto, 'litros', $con, $ClassHerramientasDptoOperativo);
    generarHojaPorTipo($spreadsheet, $estaciones, $meses, $year, $producto, 'pesos', $con, $ClassHerramientasDptoOperativo);
}

// Eliminar la primera hoja creada automáticamente
$spreadsheet->removeSheetByIndex(0);

// Establecer la hoja activa a la primera
$spreadsheet->setActiveSheetIndex(0);



// Exportar a un archivo Excel
$writer = new Xlsx($spreadsheet);
$nombreArchivo = 'Reporte Anual de Concentrado de Ventas ' . $nombreES . ' ' . $year . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>