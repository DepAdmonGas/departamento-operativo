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

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con) {
    $sql_year = "SELECT id FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
    $result_year = mysqli_query($con, $sql_year);
    $row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC);
    $idyear = $row_year['id'];

    $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
    $result_mes = mysqli_query($con, $sql_mes);
    $row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC);

    return $row_mes['id'];
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
            $cantidad += $row_listatotal['cantidad'];
            $precio = $row_listatotal['precio_unitario'];
            $total += $cantidad * $precio;
        }
    }
    return $total;
}

// Generar el contenido HTML para el PDF
$html = '<html>
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
        width: calc(100% - 30px);
        height: 100%;
        margin: 0 auto;
        padding: 40px;
        box-sizing: border-box;
    }

    .custom-table {
        width: 100%;
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
<div class="content-wrapper">';

$html .= '
<h1 style="font-size: 22px; text-align: start;">Reporte Anual '.$year.' <br> Resumen de Aceites</h1>';

$html .= '<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
<tr>';

$html .= '<th>Estación</th>'; // Agrega una columna para las estaciones

foreach ($meses as $mes) {
    $html .= '<th>' . nombremes($mes) . '</th>'; // Agrega columnas para cada mes
}
$html .= '<th>Total</th>'; // Columna para el total

$html .= '</tr>
</thead>
<tbody class="contenido-table-bg">';

// Inicializar el array para los totales
$totalesMeses = array_fill(0, count($meses), 0);

foreach ($estaciones as $indexEstacion => $estacion) {
    $datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($estacion);
    $nombreEstacion = $datosEstaciones['localidad'];
    $html .= '<tr><th>' . $nombreEstacion . '</th>'; // Nombre de la estación
    $sumaTotalEstacion = 0;

    foreach ($meses as $indexMes => $mes) {
        $IdReporte = IdReporte($estacion, $year, $mes, $con);
        $sumaTotalMesEstacion = 0;

        $sql_listaaceites = "SELECT id_aceite FROM op_aceites_lubricantes_reporte WHERE id_mes = '$IdReporte' ORDER BY id_aceite ASC";
        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
            $noaceite = $row_listaaceites['id_aceite'];
            $totalprecio = totalprecio($IdReporte, $noaceite, $con);
            $sumaTotalMesEstacion += $totalprecio;
        }
        $sumaTotalEstacion += $sumaTotalMesEstacion;
        $totalesMeses[$indexMes] += $sumaTotalMesEstacion;
        $html .= '<td style="text-align: right;">$' . number_format($sumaTotalMesEstacion, 2) . '</td>';
    }

    $html .= '<td style="text-align: right;"><strong>$' . number_format($sumaTotalEstacion, 2) . '</strong></td>';
    $html .= '</tr>';
}

// Fila de totales
$html .= '<tr class="title-table-bg"><th>Total Neto</th>';
foreach ($totalesMeses as $totalMes) {
    $html .= '<td style="text-align: right;"><strong>$' . number_format($totalMes, 2) . '</strong></td>';
}
$totalGeneral = array_sum($totalesMeses);
$html .= '<td style="text-align: right;"><strong>$' . number_format($totalGeneral, 2) . '</strong></td>';
$html .= '</tr>';

$html .= '</tbody>
</table>
</div>
</body>
</html>';

// Cargar el HTML en DOMPDF
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño del papel y la orientación
$dompdf->setPaper('legal', 'landscape');

// Renderizar el PDF
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte Anual de Aceites ' . $nombreES . ' - ' . $year . '.pdf', ['Attachment' => 1]);
