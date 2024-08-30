<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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

// Crear HTML para el reporte
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


$html .= '<h2>Reporte Anual (' . $nombreES . '), '.$year.' <br> Concentrado de Ventas</h2>';
$html .= '<table class="custom-table" style="font-size: .8em;" width="100%">';
$html .= '<thead class="tables-bg"><tr><th style="text-align: center;" >Mes</th>';

foreach ($productos as $producto) {
    $html .= '<th style="background-color:'.$colores[$producto].'; color: #fff;">'.$producto.'<br>(Litros)</th>';
    $html .= '<th style="background-color:'.$colores[$producto].'; color: #fff;">'.$producto.'<br>(Pesos)</th>';
}

$html .= '</tr></thead><tbody class="contenido-table-bg">';

foreach ($meses as $mes) {
    $html .= '<tr><th>'.nombremes($mes).'</th>';

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

        $html .= '<td style="text-align: center;">'.number_format($ProductoLitros, 2).'</td>';
        $html .= '<td style="text-align: center;">$'.number_format($ProductoPesos, 2).'</td>';
    }

    $html .= '</tr>';
}

$html .= '<tr class="total title-table-bg"><th>Total Neto</th>';

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

    $html .= '<td style="text-align: center; font-weight:bold;">'.number_format($productoTotalLitros, 2).'</td>';
    $html .= '<td style="text-align: center; font-weight:bold;">$'.number_format($productoTotalPesos, 2).'</td>';
}

$html .= '</tr>
</tbody>
</table>
</div>
</body>
</html>';

// Inicializar dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Cargar el HTML
$dompdf->loadHtml($html);

// (Opcional) Establecer el tamaño de la página y la orientación
$dompdf->setPaper('legal', 'landscape');

// Renderizar el PDF
$dompdf->render();

// Enviar el PDF al navegador
//header('Content-Type: application/pdf');
//header('Content-Disposition: attachment; filename="Reporte Anual de Ventas '.$nombreES.' - '.$year.'.pdf"');
$dompdf->stream('Reporte Anual de Ventas '.$nombreES.' - '.$year.'.pdf', ['Attachment' => 1]);


exit();

