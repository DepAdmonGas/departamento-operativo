<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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
$html = '<html><head>

<style>


body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url('.RUTA_IMG_LOGOS.'Fondo2.jpg); /* Usa la ruta correcta */
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
      padding-bottom: 10px;
      padding-top: 10px;
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

$html .= '<h2>Reporte Anual ('.$nombreES.'), '.$year.' <br> Resumen de Aceites</h2>';
$html .= '<table class="custom-table" style="font-size: .8em;" width="100%"><thead class="tables-bg"><tr>';
$html .= '<th>Mes</th>'; // Agrega una columna para los meses

foreach ($estaciones as $estacion) {
    $datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($estacion);
    $nombreEstacion = $datosEstaciones['localidad'];
    $html .= '<th>Monto (Pesos) </th>'; // Agrega columnas para cada estación
}

$html .= '</tr></thead><tbody class="contenido-table-bg">';

// Inicializar el array para los totales
$totalesEstaciones = array_fill(0, count($estaciones), 0);
$totalesMeses = array_fill(0, count($meses), 0);

foreach ($meses as $indexMes => $mes) {
    $html .= '<tr><th>' . nombremes($mes) . '</th>'; // Nombre del mes
    $sumaTotalMes = 0;

    foreach ($estaciones as $indexEstacion => $estacion) {
        $IdReporte = IdReporte($estacion, $year, $mes, $con);
        $sumaTotalEstacionMes = 0;

        $sql_listaaceites = "SELECT id_aceite FROM op_aceites_lubricantes_reporte WHERE id_mes = '$IdReporte' ORDER BY id_aceite ASC";
        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
            $noaceite = $row_listaaceites['id_aceite'];
            $totalprecio = totalprecio($IdReporte, $noaceite, $con);
            $sumaTotalEstacionMes += $totalprecio;
        }
        $sumaTotalMes += $sumaTotalEstacionMes;
        $totalesEstaciones[$indexEstacion] += $sumaTotalEstacionMes;
        $html .= '<td style="text-align: right;">$' . number_format($sumaTotalEstacionMes, 2) . '</td>';
    }


    $html .= '</tr>';
}

// Fila de totales
$html .= '<tr><th>Total Anual</th>';
foreach ($totalesEstaciones as $totalEstacion) {
    $html .= '<td style="text-align: right;"><strong>$' . number_format($totalEstacion, 2) . '</strong></td>';
}

$html .= '</tr>';

$html .= '</tbody>
</table>
</div>
</body>
</html>';

// Configuración de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño de la página y la orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
$dompdf->render();

// Enviar el archivo PDF al navegador
$dompdf->stream('Reporte Anual de Aceites ' . $nombreES . ' - ' . $year . '.pdf', ['Attachment' => 1]);
