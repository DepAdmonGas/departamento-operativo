<?php
require ('../../../../../app/help.php');
require ('../../../../../app/lib/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Obtén los valores de idEstacion y year desde la URL
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

// Determinar el nombre de la estación o si es un reporte general
if ($idEstacion == 0) {
    $nombreES = 'General';
    $consulta = '';
    $nombreTB = "Estacion/Departamento";
} else {
    $sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
    $result_estacion = mysqli_query($con, $sql_estacion);
    while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $nombreES = $row_estacion['localidad'];    
    }
    $consulta = "AND op_recibo_nomina_v2.id_estacion = $idEstacion";
    $nombreTB = "Estacion";
}

// Crear el objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte Anual '.$year.'');

// Encabezado de columnas
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', $nombreTB);
$meses = [
    'Ene' => 'Enero',
    'Feb' => 'Febrero',
    'Mar' => 'Marzo',
    'Abr' => 'Abril',
    'May' => 'Mayo',
    'Jun' => 'Junio',
    'Jul' => 'Julio',
    'Ago' => 'Agosto',
    'Sep' => 'Septiembre',
    'Oct' => 'Octubre',
    'Nov' => 'Noviembre',
    'Dic' => 'Diciembre',
];
$col = 'C';
foreach ($meses as $abreviatura => $mes) {
    $sheet->setCellValue("{$col}1", $mes);
    $col++;
}
// Columna de Total Anual en negritas
$sheet->setCellValue('O1', 'Total');
$sheet->getStyle('O1')->getFont()->setBold(true);

// Consulta SQL para obtener los datos
$sql_lista = "
SELECT 
  op_recibo_nomina_v2.id_estacion, 
  op_rh_localidades.localidad AS nombre_estacion, 
  COALESCE(SUM(CASE WHEN mes = 1 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Ene,
  COALESCE(SUM(CASE WHEN mes = 2 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Feb,
  COALESCE(SUM(CASE WHEN mes = 3 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Mar,
  COALESCE(SUM(CASE WHEN mes = 4 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Abr,
  COALESCE(SUM(CASE WHEN mes = 5 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS May,
  COALESCE(SUM(CASE WHEN mes = 6 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Jun,
  COALESCE(SUM(CASE WHEN mes = 7 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Jul,
  COALESCE(SUM(CASE WHEN mes = 8 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Ago,
  COALESCE(SUM(CASE WHEN mes = 9 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Sep,
  COALESCE(SUM(CASE WHEN mes = 10 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Oct,
  COALESCE(SUM(CASE WHEN mes = 11 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Nov,
  COALESCE(SUM(CASE WHEN mes = 12 AND op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS Dic,
  COALESCE(SUM(CASE WHEN op_recibo_nomina_v2.importe_total != 1 THEN op_recibo_nomina_v2.importe_total ELSE 0 END), 0) AS TotalAnual
FROM 
  op_recibo_nomina_v2
INNER JOIN 
  op_rh_localidades 
ON 
  op_recibo_nomina_v2.id_estacion = op_rh_localidades.id
WHERE 
  year = '".$year."' $consulta
  AND op_recibo_nomina_v2.id_estacion NOT IN (6, 7)
GROUP BY 
  op_recibo_nomina_v2.id_estacion, op_rh_localidades.localidad
ORDER BY 
  op_rh_localidades.numlista ASC";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$num = 1;
$rowNum = 2; // Empezar desde la fila 2

// Al final del código que escribe las filas de datos, justo antes de cerrar el if($numero_lista > 0)
if ($numero_lista > 0) {
  // Escribir cada fila de datos en el archivo
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
      
      $sheet->setCellValue("A{$rowNum}", $num);
      $sheet->setCellValue("B{$rowNum}", $row_lista["nombre_estacion"]);
      $colNum = 'C';

      foreach ($meses as $abreviatura => $nombreMes) {
          // Convertir el valor en número y escribirlo en la celda
          $valor = (float) $row_lista[$abreviatura];
          $sheet->setCellValue("{$colNum}{$rowNum}", $valor);
          // Formatear la celda con 2 decimales
          $sheet->getStyle("{$colNum}{$rowNum}")
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
          $colNum++;
      }
      // Colocar Total Anual en negritas y formateado con 2 decimales
      $totalAnual = (float) $row_lista["TotalAnual"];
      $sheet->setCellValue("O{$rowNum}", $totalAnual);
      $sheet->getStyle("O{$rowNum}")
          ->getFont()
          ->setBold(true);
      $sheet->getStyle("O{$rowNum}")
          ->getNumberFormat()
          ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

      $num++;
      $rowNum++;
  }

  if ($idEstacion == 0) {

  // Agregar una fila para los totales
  $sheet->setCellValue("B{$rowNum}", 'Total Neto');
  $sheet->getStyle("A{$rowNum}:O{$rowNum}")->getFont()->setBold(true);
  $colNum = 'C';
  foreach ($meses as $abreviatura => $nombreMes) {
      $sheet->setCellValue("{$colNum}{$rowNum}", "=SUM({$colNum}2:{$colNum}".($rowNum-1).")");
      $sheet->getStyle("{$colNum}{$rowNum}")
          ->getNumberFormat()
          ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
      $colNum++;
  }
  // Total anual
  $sheet->setCellValue("O{$rowNum}", "=SUM(O2:O".($rowNum-1).")");
  $sheet->getStyle("O{$rowNum}")
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
  }

      
} else {
    // Si no se encontró información, escribir una fila con un mensaje
    $sheet->setCellValue('A2', 'S/I');
}

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'P') as $columnID) {
  $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Exportar a un archivo Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte Anual de Recibos de Nomina '.$nombreES.' - '.$year.'.xlsx"');
$writer->save('php://output');