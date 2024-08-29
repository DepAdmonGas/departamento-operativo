<?php
require ('../../../../../app/help.php');
require ('../../../../../app/lib/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$productos = ['G SUPER', 'G PREMIUM', 'G DIESEL'];
$colores = [
    'G SUPER' => '#76bd1d',
    'G PREMIUM' => '#e21683',
    'G DIESEL' => '#000000'
];
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


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte Anual '.$year.'');

// Encabezado de columnas
$sheet->setCellValue('A1', 'Mes');
$col = 2;
foreach ($productos as $producto) {
    // Usar \n para saltos de línea dentro de la celda
    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . '1', $producto . "\n(Litros)");
    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . '1', $producto . "\n(Pesos)");

    // Ajustar el ajuste de texto para que se muestre el salto de línea
    $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col - 2) . '1')->getAlignment()
        ->setWrapText(true);
    $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col - 1) . '1')->getAlignment()
        ->setWrapText(true);

    // Aplicar color de fondo a los encabezados de productos
    $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col - 2) . '1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB($colores[$producto]);
    $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col - 1) . '1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB($colores[$producto]);
}

// Datos
$rowNum = 2; // Cambiar a 2 ya que la fila 1 se usa para encabezados de columnas
foreach ($meses as $mes) {
    $sheet->setCellValue('A' . $rowNum, nombremes($mes));

    $colNum = 2;
    $mesTotalLitros = 0;
    $mesTotalPesos = 0;

    foreach ($productos as $producto) {
        $sql_listadia = "
        SELECT
        op_corte_year.id_estacion,
        op_corte_year.year,
        op_corte_dia.id AS idDia
        FROM op_corte_year
        INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
        INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
        WHERE op_corte_year.id_estacion = '" . $idEstacion . "'
        AND op_corte_year.year = '" . $year . "'
        AND op_corte_mes.mes = '" . $mes . "'";

        $result_listadia = mysqli_query($con, $sql_listadia);

        $ProductoLitros = 0;
        $ProductoPesos = 0;

        while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
            $idDias = $row_listadia['idDia'];
            $ProductoData = TotalVentas($idDias, $producto, $con);

            $ProductoLitros += $ProductoData['TotalLitros'];
            $ProductoPesos += $ProductoData['TotalPrecio'];
        }

        $mesTotalLitros += $ProductoLitros;
        $mesTotalPesos += $ProductoPesos;

        // Asignación de valores numéricos para cada mes
        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
        $sheet->setCellValueExplicit($cellCoordinate, $ProductoLitros, DataType::TYPE_NUMERIC);
        $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00'); // Formato con separador de miles

        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
        $sheet->setCellValueExplicit($cellCoordinate, $ProductoPesos, DataType::TYPE_NUMERIC);
        $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD); // Formato de moneda
    }

    $rowNum++;
}

// Total
$sheet->setCellValue('A' . $rowNum, 'Total Neto');
$colNum = 2;
$totalEstacionLitros = 0;
$totalEstacionPesos = 0;

foreach ($productos as $producto) {
    $productoTotalLitros = 0;
    $productoTotalPesos = 0;

    foreach ($meses as $mes) {
        $sql_listadia = "
        SELECT
        op_corte_year.id_estacion,
        op_corte_year.year,
        op_corte_dia.id AS idDia
        FROM op_corte_year
        INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
        INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
        WHERE op_corte_year.id_estacion = '" . $idEstacion . "'
        AND op_corte_year.year = '" . $year . "'
        AND op_corte_mes.mes = '" . $mes . "'";

        $result_listadia = mysqli_query($con, $sql_listadia);

        while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
            $idDias = $row_listadia['idDia'];
            $ProductoData = TotalVentas($idDias, $producto, $con);

            $productoTotalLitros += $ProductoData['TotalLitros'];
            $productoTotalPesos += $ProductoData['TotalPrecio'];
        }
    }

    $totalEstacionLitros += $productoTotalLitros;
    $totalEstacionPesos += $productoTotalPesos;

    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
    $sheet->setCellValueExplicit($cellCoordinate, $productoTotalLitros, DataType::TYPE_NUMERIC);
    $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode('#,##0.00'); // Formato con separador de miles

    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum++) . $rowNum;
    $sheet->setCellValueExplicit($cellCoordinate, $productoTotalPesos, DataType::TYPE_NUMERIC);
    $sheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD); // Formato de moneda
}

// Aplicar negrita a la fila de totales
$sheet->getStyle('A' . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 6) . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 5) . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 4) . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 3) . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 2) . $rowNum)->getFont()->setBold(true);
$sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum - 1) . $rowNum)->getFont()->setBold(true);

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNum)) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Exportar a un archivo Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte Anual de Concentrado de Ventas '.$nombreES.' - '.$year.'.xlsx"');
$writer->save('php://output');
?>
