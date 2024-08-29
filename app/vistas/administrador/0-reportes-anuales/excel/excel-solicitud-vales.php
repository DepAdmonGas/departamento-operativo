<?php
require ('../../../../../app/lib/vendor/autoload.php');
require ('../../../../../app/help.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];


if ($idEstacion == 0) {
    $nombreES = 'General';
    $consulta = '';
    $nombreTB = "Estacion/Cuenta";
} else {
    $sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
    $result_estacion = mysqli_query($con, $sql_estacion);
    while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $nombreES = $row_estacion['localidad'];	
    }
    
    $consulta = "AND id_estacion = $idEstacion";
    $nombreTB = "Estacion";
}


$meses = [
    "Ene" => "Enero", 
    "Feb" => "Febrero", 
    "Mar" => "Marzo", 
    "Abr" => "Abril", 
    "May" => "Mayo", 
    "Jun" => "Junio", 
    "Jul" => "Julio", 
    "Ago" => "Agosto", 
    "Sep" => "Septiembre", 
    "Oct" => "Octubre", 
    "Nov" => "Noviembre", 
    "Dic" => "Diciembre"
];

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar encabezados
$sheet->setCellValue('A1', $nombreTB);

$column = 'B';
foreach ($meses as $abreviado => $completo) {
    $sheet->setCellValue($column . '1', $completo);
    $column++;
}
$sheet->setCellValue($column . '1', 'Total');

// Inicializar variables para los totales
$totalesMes = array_fill(0, 12, 0);
$totalAnualGeneral = 0;

// Consulta SQL con año dinámico
$sql_listadia = "SELECT 
                    IF(id_estacion = 0, cuenta, id_estacion) AS Estacion,
                    SUM(CASE WHEN id_mes = 1 THEN monto ELSE 0 END) AS Ene,
                    SUM(CASE WHEN id_mes = 2 THEN monto ELSE 0 END) AS Feb,
                    SUM(CASE WHEN id_mes = 3 THEN monto ELSE 0 END) AS Mar,
                    SUM(CASE WHEN id_mes = 4 THEN monto ELSE 0 END) AS Abr,
                    SUM(CASE WHEN id_mes = 5 THEN monto ELSE 0 END) AS May,
                    SUM(CASE WHEN id_mes = 6 THEN monto ELSE 0 END) AS Jun,
                    SUM(CASE WHEN id_mes = 7 THEN monto ELSE 0 END) AS Jul,
                    SUM(CASE WHEN id_mes = 8 THEN monto ELSE 0 END) AS Ago,
                    SUM(CASE WHEN id_mes = 9 THEN monto ELSE 0 END) AS Sep,
                    SUM(CASE WHEN id_mes = 10 THEN monto ELSE 0 END) AS Oct,
                    SUM(CASE WHEN id_mes = 11 THEN monto ELSE 0 END) AS Nov,
                    SUM(CASE WHEN id_mes = 12 THEN monto ELSE 0 END) AS Dic,
                    SUM(monto) AS TotalAnual
                FROM 
                    op_solicitud_vale
                WHERE 
                    id_year = $year
                    AND status != 0 $consulta
                GROUP BY 
                    Estacion";

$result_listadia = mysqli_query($con, $sql_listadia);
$rowNum = 2;

while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
    $datosEstaciones2 = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_listadia["Estacion"]);
    $estacion = is_numeric($row_listadia["Estacion"]) ? $datosEstaciones2['localidad'] : $row_listadia["Estacion"];

    // Agregar valores a la hoja de cálculo
    $sheet->setCellValue('A' . $rowNum, $estacion);
    
    $column = 'B';
    foreach ($meses as $abreviado => $completo) {
        $mesMonto = $row_listadia[$abreviado];
        $sheet->setCellValue($column . $rowNum, $mesMonto); // Mantener el valor como número
        $totalesMes[array_search($abreviado, array_keys($meses))] += $mesMonto;
        $column++;
    }
    
    $sheet->setCellValue($column . $rowNum, $row_listadia["TotalAnual"]); // Mantener el total anual como número
    $totalAnualGeneral += $row_listadia["TotalAnual"];
    $rowNum++;
}

if($idEstacion == 0){
// Agregar fila de totales
$sheet->setCellValue('A' . $rowNum, 'Total Neto');
$column = 'B';
foreach ($totalesMes as $totalMes) {
    $sheet->setCellValue($column . $rowNum, $totalMes); // Mantener el total como número
    $column++;
}

$sheet->setCellValue($column . $rowNum, $totalAnualGeneral); // Mantener el total anual general como número
}

// Aplicar formato de moneda a las celdas
$sheet->getStyle('B2:' . $column . $rowNum)
    ->getNumberFormat()
    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'P') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Exportar a un archivo Excel
$writer = new Xlsx($spreadsheet);
$nombreArchivo = 'Reporte Anual de Solicitud de Vales ' . $nombreES . ' ' . $year . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>