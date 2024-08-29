<?php
require '../../../../../app/lib/dompdf/vendor/autoload.php';
require '../../../../../app/help.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Obtén los valores de idEstacion y year desde la URL
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

// Determinar el nombre de la estación o si es un reporte general
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
    $consulta = "AND op_recibo_nomina_v2.id_estacion = $idEstacion";
    $nombreTB = "Estacion";
    $tableOP = 'th';
    $estiloTexto = 'font-weight: normal;';
}

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

// Consulta para obtener el total por mes y total anual general
$sql_totales = "
SELECT 
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
WHERE 
  year = '".$year."' $consulta
  AND op_recibo_nomina_v2.id_estacion NOT IN (6, 7)";

$result_totales = mysqli_query($con, $sql_totales);
$totales = mysqli_fetch_array($result_totales, MYSQLI_ASSOC);

$html = '
<html>
<head>

<style>

body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url('.RUTA_IMG_LOGOS.'Fondo1.jpg); /* Usa la ruta correcta */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}


.content-wrapper {
    position: relative;
    z-index: 1;
    width: calc(100% - 40px); /* Ajusta el ancho de acuerdo al padding */
    height: 100%;
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
        max-width: 80px; /* Ajusta según tus necesidades */
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
<div class="content-wrapper">

<h1 style="font-size: 22px; text-align: start;">Reporte Anual ('.$nombreES.') <br> Recibos de Nomina '.$year.'</h1>

  <table class="custom-table" style="font-size: .8em;" width="100%">
    <thead class="tables-bg">

    <tr>';

    if ($idEstacion == 0) {
    $html .= '<th>No.</th>
        <th>'.$nombreTB.'</th>';
    }

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

foreach ($meses as $mes) {
    $html .= '<th>'.$mes.'</th>';
}

$html .= '<th><b>Total</b></th>';
$html .= '</tr>
    </thead>';

$num = 1;
if ($numero_lista > 0) {
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
        $html .= '<tbody class="contenido-table-bg">

        <tr>';

        if ($idEstacion == 0) {
        $html .= '<th>'.$num.'</th>';
        $html .= '<td>'.$row_lista["nombre_estacion"].'</td>';
        }

        foreach ($meses as $abreviatura => $nombreMes) {
            $valor = number_format((float)$row_lista[$abreviatura], 2);
            $html .= '<'.$tableOP.' style="text-align:right;'.$estiloTexto.'">$'.$valor.'</'.$tableOP.'>';
        }
        
        $totalAnual = number_format((float)$row_lista["TotalAnual"], 2);
        $html .= '<td style="text-align:right; font-weight:bold;">$'.$totalAnual.'</td>';
        $html .= '</tr>';
        
        $num++;
    }

    if ($idEstacion == 0) {
    // Agregar fila de totales
    $html .= '<tr class="title-table-bg">';
    $html .= '<th colspan="2" style="text-align:center;">Total Neto:</th>';
    
    foreach ($meses as $abreviatura => $nombreMes) {
        $totalMes = number_format((float)$totales[$abreviatura], 2);
        $html .= '<td style="text-align:right;"><b>$'.$totalMes.'</b></td>';
    }
    
    $totalGeneral = number_format((float)$totales["TotalAnual"], 2);
    $html .= '<td style="text-align:right; font-weight:bold;">$'.$totalGeneral.'</td>';
    $html .= '</tr>';
    }

} else {
    $html .= '<tr><td colspan="15" style="text-align:center;">No se encontro información</td></tr>';
}

$html .= '    </tbody>
</table>

</div>

<body>
<html>';

// Cargar el HTML en DOMPDF
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño del papel y la orientación
$dompdf->setPaper('legal', 'landscape');

// Renderizar el PDF
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte Anual de Recibos de Nomina '.$nombreES.' - '.$year.'.pdf', array('Attachment' => 1));

