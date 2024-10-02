<?php
require '../../../../../app/lib/dompdf/vendor/autoload.php';
require '../../../../../app/help.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

if ($idEstacion == 0) {
    $nombreES = 'General';
    $consulta = '';
    $nombreTB = "Estacion <br>o<br> Depto.";
    $tableOP = 'td';
    $estiloTexto = '';
    
} else {
    $sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
    $result_estacion = mysqli_query($con, $sql_estacion);
    while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $nombreES = $row_estacion['localidad'];	
    }
    
    $consulta = "AND op_solicitud_cheque.id_estacion = $idEstacion";
    $nombreTB = "Estacion";
    $tableOP = 'th';
    $estiloTexto = 'font-weight: normal;';
}

// Variables para almacenar los totales por mes y el total neto
$totalEne = $totalFeb = $totalMar = $totalAbr = $totalMay = $totalJun = $totalJul = $totalAgo = $totalSep = $totalOct = $totalNov = $totalDic = $totalNeto = 0;

// Construir el HTML

// Construir el HTML
$html = "
<html>
<head>

<style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url(".RUTA_IMG_LOGOS."Fondo1.jpg); /* Usa la ruta correcta */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}


.content-wrapper {
    position: relative;
    z-index: 1;
    width: calc(100% - 40px); /* Ajusta el ancho de acuerdo al padding */
    height: 90%;
    margin: 0 auto; /* Centra el contenido horizontalmente */
    padding: 40px; /* Aquí puedes ajustar el padding */
    box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
}

.custom-table {
    width: 100%; /* Asegúrate de que la tabla ocupe el 100% del área disponible */
   
}
    /* Ajuste adicional para las celdas de la tabla */
    .custom-table th,
    .custom-table td {
        max-width: 100px; /* Ajusta según tus necesidades */
        word-wrap: break-word;
    }
      
    .custom-table thead tr, .custom-table thead th {
      border-top: none;
      border-bottom: none !important;
      text-transform: uppercase;
    }
    
    /* Estilo para th en el encabezado de la tabla */
    .custom-table thead th {
      color: #000;
      padding-bottom: 6px;
      padding-top: 6px;
      font-size: 9.5px !important;
    }
    
    .custom-table thead th small {
      color: #000;
    }
     
    /* Estilo para th en el cuerpo de la tabla con mayor especificidad */
    .custom-table thead tr th {
      border: none; 
      color: #fff;
    }
    
    /*---------- TD (DESING TD) ----------- */
    .custom-table tbody th, .custom-table tbody td {
      /* color: #000; */
      padding-bottom: 10px;
      padding-top: 10px;
      font-size: 11px !important;
    }
    
    .custom-table tbody th small, .custom-table tbody td small {
      color: #aaaaaa;
    }
    
    .custom-table tbody tr th, .custom-table tbody tr td {
      border: none; 
    }
    
    /* Asegúrate de que no haya reglas más específicas que sobrescriban esta */
.custom-table tbody th, .custom-table tbody td {
    cursor: pointer !important;
  }
    
    .custom-table thead tr th:first-child, .custom-table tbody tr td:first-child{
      border-top-left-radius: 7px;
      border-bottom-left-radius: 0px; 
      
    }
    
    .custom-table thead tr th:last-child {
      border-top-right-radius: 7px;
      border-bottom-right-radius: 0px; 
    }
    
    .custom-table tbody tr.active {
      opacity: .4; 
    }

    /* Mantener el estilo hover para las filas */
    .custom-table tbody tr:hover {
        background-color: #e1e1e1 !important; /* Cambia el color de fondo cuando se hace hover */
        cursor: pointer; /* Cambia el cursor a una mano cuando pasa sobre la fila */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover, 
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover,
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }


    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover2, 
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }
    
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover2,
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hoverRed, 
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */
    }
        
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hoverRed,
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */

    }

    .tables-bg {
        background: #215D98;
        color: white;
    }

    .title-table-bg {
    background: #749ABF;
    color: white;
    }

    .contenido-table-bg {
    background: #f2f2f2;
    color: dark;
    }


</style>
</head>

<body>

<div class='content-wrapper'>
    <h1 style='font-size: 22px; text-align: start;'>Reporte Anual (".$nombreES.") <br> Solicitud de Cheques ".$year."</h1>

      <table class='custom-table' style='font-size: .8em;' width='100%'>
    <thead class='tables-bg'>

<tr>";

if ($idEstacion == 0) {

$arrayHead = [
    'No.', $nombreTB,
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
    'Total'
];
}else{
$arrayHead = [
       
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
        'Total'
];  
}

foreach ($arrayHead as $head) {
    $html .= "<th>{$head}</th>";
}

$html .= "
            </tr>
        </thead>

       <tbody class='contenido-table-bg'>
";

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

if (mysqli_num_rows($result_lista) > 0) {
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
        $html .= "<tr>";

        if ($idEstacion == 0) {
        $html .= "
                <th>{$num}</th>
                <td>{$row_lista["nombre_estacion"]}</td>";
        }

        $html .="         
                <$tableOP style='text-align:right; $estiloTexto'>$".number_format($row_lista["Ene"], 2)."</$tableOP>
                <td style='text-align:right;'>$".number_format($row_lista["Feb"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Mar"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Abr"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["May"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Jun"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Jul"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Ago"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Sep"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Oct"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Nov"], 2)."</td>
                <td style='text-align:right;'>$".number_format($row_lista["Dic"], 2)."</td>
                <td style='text-align:right;' class='total'><b>$".number_format($row_lista["TotalAnual"], 2)."</b></td>
            </tr>
        ";
        
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

        $num++;
    }

    if ($idEstacion == 0) {
    // Agregar la fila con los totales al final de la tabla
    $html .= "
        <tr class='total title-table-bg'>
            <th colspan='2'>Total Neto:</th>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalEne, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalFeb, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalMar, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalAbr, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalMay, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalJun, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalJul, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalAgo, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalSep, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalOct, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalNov, 2)."</td>
            <td style='text-align:right; font-weight:bold;'>$".number_format($totalDic, 2)."</td>
            <td style='text-align:right; font-weight:bold;' class='total'>$".number_format($totalNeto, 2)."</td>
        </tr>";
    }

} else {
    $html .= "
        <tr>
            <td style='text-align:center;' colspan='15'>No se encontro información</td>
        </tr>
    ";
}

$html .= "
        </tbody>
    </table>
    </div>
</body>
</html>
";

// Configurar Dompdf y generar el PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('legal', 'landscape');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte Anual de Solicitud de Cheques '.$nombreES.' - '.$year.'.pdf', ['Attachment' => 1]);
?>
