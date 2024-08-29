<?php
require ('../../../../../app/help.php');
require ('../../../../../app/lib/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Font;

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

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
    
    $consulta = "AND op_solicitud_cheque.id_estacion = $idEstacion";
    $nombreTB = "Estacion";
}

// Crear una nueva hoja de cálculo de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte Anual '.$nombreES.' '.$year.'');

// Escribir los encabezados de las columnas en la primera fila
$arrayHead = [
    'No.', $nombreTB,
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
    'Total'
];

$sheet->fromArray($arrayHead, NULL, 'A1');

// Variables para almacenar los totales por mes y el total neto
$totalEne = $totalFeb = $totalMar = $totalAbr = $totalMay = $totalJun = $totalJul = $totalAgo = $totalSep = $totalOct = $totalNov = $totalDic = $totalNeto = 0;

// Consulta SQL para obtener los datos
$sql_lista = "
SELECT 
  op_solicitud_cheque.id_estacion, 
  CASE 
      WHEN op_solicitud_cheque.id_estacion = 8 THEN tb_puestos.tipo_puesto
      ELSE tb_estaciones.nombre
  END AS nombre_estacion,  
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 1 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Ene,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 2 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Feb,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 3 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Mar,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 4 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Abr,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 5 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS May,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 6 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Jun,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 7 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Jul,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 8 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Ago,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 9 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Sep,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 10 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Oct,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 11 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Nov,
  COALESCE(SUM(CASE WHEN op_solicitud_cheque.id_mes = 12 THEN op_solicitud_cheque.monto ELSE 0 END), 0) AS Dic,
  COALESCE(SUM(op_solicitud_cheque.monto), 0) AS TotalAnual
FROM op_solicitud_cheque
LEFT JOIN tb_estaciones ON op_solicitud_cheque.id_estacion = tb_estaciones.id
LEFT JOIN tb_puestos ON op_solicitud_cheque.depto = tb_puestos.id AND op_solicitud_cheque.id_estacion = 8
WHERE op_solicitud_cheque.id_year = ".$year."
AND op_solicitud_cheque.status != 0 ".$consulta."
GROUP BY op_solicitud_cheque.id_estacion, nombre_estacion
ORDER BY 
  CASE 
      WHEN op_solicitud_cheque.id_estacion = 8 THEN 1 
      ELSE 0 
  END, 
  op_solicitud_cheque.id_estacion ASC";

$result_lista = mysqli_query($con, $sql_lista);
$num = 1;
$rowNum = 2;

if (mysqli_num_rows($result_lista) > 0) {
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
        $arrayContenido = [
            $num,
            $row_lista["nombre_estacion"],
            $row_lista["Ene"],
            $row_lista["Feb"],
            $row_lista["Mar"],
            $row_lista["Abr"],
            $row_lista["May"],
            $row_lista["Jun"],
            $row_lista["Jul"],
            $row_lista["Ago"],
            $row_lista["Sep"],
            $row_lista["Oct"],
            $row_lista["Nov"],
            $row_lista["Dic"],
            $row_lista["TotalAnual"]
        ];

        $sheet->fromArray($arrayContenido, NULL, "A{$rowNum}");

        // Sumar los totales por mes y el total neto
        $totalEne += $row_lista["Ene"];
        $totalFeb += $row_lista["Feb"];
        $totalMar += $row_lista["Mar"];
        $totalAbr += $row_lista["Abr"];
        $totalMay += $row_lista["May"];
        $totalJun += $row_lista["Jun"];
        $totalJul += $row_lista["Jul"];
        $totalAgo += $row_lista["Ago"];
        $totalSep += $row_lista["Sep"];
        $totalOct += $row_lista["Oct"];
        $totalNov += $row_lista["Nov"];
        $totalDic += $row_lista["Dic"];
        $totalNeto += $row_lista["TotalAnual"];

        // Aplicar formato de número con 2 decimales y símbolo de moneda
        foreach (range('C', 'P') as $column) {
            $sheet->getStyle("{$column}{$rowNum}")
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        }

        $sheet->getStyle("O{$rowNum}")->getFont()->setBold(true);

        $num++;
        $rowNum++;
    }


    if($idEstacion == 0){
    // Agregar una fila para mostrar los totales
    $totales = [
        '', 'Total Neto', 
        $totalEne, $totalFeb, $totalMar, $totalAbr, $totalMay, $totalJun, 
        $totalJul, $totalAgo, $totalSep, $totalOct, $totalNov, $totalDic, 
        $totalNeto
    ];
    
    $sheet->fromArray($totales, NULL, "A{$rowNum}");

    // Aplicar formato de número con 2 decimales y símbolo de moneda a la fila de totales
    foreach (range('C', 'P') as $column) {
        $sheet->getStyle("{$column}{$rowNum}")
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    }

    // Aplicar negritas a la fila de totales
    $sheet->getStyle("A{$rowNum}:P{$rowNum}")->getFont()->setBold(true);
    
            
}

} else {
    // Si no se encontró información, escribir una fila con un mensaje
    $mensaje = array_fill(0, 15, 'S/I');
    $sheet->fromArray($mensaje, NULL, "A2");
}

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'P') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Exportar el archivo Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte Anual de Solicitud de Cheques '.$nombreES.' - '.$year.'.xlsx"');
$writer->save('php://output');
?>
