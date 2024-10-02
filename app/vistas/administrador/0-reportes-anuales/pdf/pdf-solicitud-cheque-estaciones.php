<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

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
    background-image: url(".RUTA_IMG_LOGOS."Fondo2.jpg); /* Usa la ruta correcta */
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
        'No.', $nombreTB, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Total'
    ];
} else {
    $arrayHead = [
        'Mes', 'Monto'
    ];
}

foreach ($arrayHead as $head) {
    $html .= "<th>{$head}</th>";
}

$html .= "
            </tr>
        </thead>
       <tbody class='contenido-table-bg'>";

// Consulta SQL permanece igual
$sql_lista = "
SELECT 
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
WHERE op_solicitud_cheque.id_year = ".$year."
AND op_solicitud_cheque.status != 0 ".$consulta;

$result_lista = mysqli_query($con, $sql_lista);
$row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC);

// Si se encontró información
if ($row_lista) {
    // Mostrar los meses como filas
    $meses = [
        'Enero' => $row_lista["Ene"],
        'Febrero' => $row_lista["Feb"],
        'Marzo' => $row_lista["Mar"],
        'Abril' => $row_lista["Abr"],
        'Mayo' => $row_lista["May"],
        'Junio' => $row_lista["Jun"],
        'Julio' => $row_lista["Jul"],
        'Agosto' => $row_lista["Ago"],
        'Septiembre' => $row_lista["Sep"],
        'Octubre' => $row_lista["Oct"],
        'Noviembre' => $row_lista["Nov"],
        'Diciembre' => $row_lista["Dic"],
    ];

    foreach ($meses as $mes => $monto) {
        $html .= "
            <tr>
                <th>{$mes}</th>
                <td style='text-align:right;'>$".number_format($monto, 2)."</td>
            </tr>";
    }

    // Agregar fila para el total anual
    $html .= "
        <tr class='total title-table-bg'>
            <th>Total Anual</th>
            <td style='text-align:right; font-weight:bold;'>$".number_format($row_lista["TotalAnual"], 2)."</td>
        </tr>";
} else {
    $html .= "
        <tr>
            <td style='text-align:center;' colspan='2'>No se encontró información</td>
        </tr>";
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte Anual de Solicitud de Cheques '.$nombreES.' - '.$year.'.pdf', ['Attachment' => 1]);
?>
