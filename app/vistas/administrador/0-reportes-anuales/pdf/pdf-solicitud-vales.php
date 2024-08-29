<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

// Genera el contenido HTML de la tabla
ob_start();
?>

<html><head>


<style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url(<?=RUTA_IMG_LOGOS?>Fondo1.jpg); /* Usa la ruta correcta */
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
      font-size: 10.5px !important;
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


</head><body>

<div class="content-wrapper">
 

<h2>Reporte Anual <?=$year?> <br> Solicitud de Vales</h2>

<div class="col-12">
    <div class="table-responsive">
        <table class="custom-table" style="font-size: .75em;" width="100%">
            <thead class="tables-bg">
                <tr>
                    <th class="text-start fw-bold">Estacion <br> o <br> Cuenta</th>
                    <?php foreach ($meses as $mes): ?>
                        <th class="text-center fw-bold"><?= nombremes($mes) ?></th>
                    <?php endforeach; ?>
                    <th class="text-center fw-bold">TOTAL ANUAL</th>
                </tr>
            </thead>
            <tbody class="contenido-table-bg">
                <?php

                // Inicializar variables para los totales de cada mes y el total anual
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
                        AND status != 0
                    GROUP BY 
                        Estacion";

                $result_listadia = mysqli_query($con, $sql_listadia);

                while ($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)) {
                    $datosEstaciones2 = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_listadia["Estacion"]);
                    $estacion = is_numeric($row_listadia["Estacion"]) ? $datosEstaciones2['localidad'] : $row_listadia["Estacion"];


    // Sumar los valores de cada mes a los totales
    $totalesMes[0] += $row_listadia["Ene"];
    $totalesMes[1] += $row_listadia["Feb"];
    $totalesMes[2] += $row_listadia["Mar"];
    $totalesMes[3] += $row_listadia["Abr"];
    $totalesMes[4] += $row_listadia["May"];
    $totalesMes[5] += $row_listadia["Jun"];
    $totalesMes[6] += $row_listadia["Jul"];
    $totalesMes[7] += $row_listadia["Ago"];
    $totalesMes[8] += $row_listadia["Sep"];
    $totalesMes[9] += $row_listadia["Oct"];
    $totalesMes[10] += $row_listadia["Nov"];
    $totalesMes[11] += $row_listadia["Dic"];

    // Sumar el total anual al total general
    $totalAnualGeneral += $row_listadia["TotalAnual"];
    

                    echo "<tr>
<th class='text-start fw-bold' style='text-align: left !important;'>" . $estacion . "</th>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Ene"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Feb"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Mar"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Abr"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["May"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Jun"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Jul"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Ago"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Sep"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Oct"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Nov"],2) . "</td>
                            <td style='text-align: right;'>$" . number_format($row_listadia["Dic"],2) . "</td>
                            <td style='text-align: right;'><b>$" . number_format($row_listadia["TotalAnual"],2) . "</b></td>
                          </tr>";
                        }

                        // Agregar fila de totales por mes al final
                        echo "<tr class='title-table-bg'>
                                <th class='text-start fw-bold' style='text-align: center !important;'>Total Neto</th>";
                        for ($i = 0; $i < 12; $i++) {
                            echo "<td style='text-align: right;'><b>$" . number_format($totalesMes[$i], 2) . "</b></td>";
                        }
                        echo "<td style='text-align: right;'><b>$" . number_format($totalAnualGeneral, 2) . "</b></td>"; // Mostrar el total anual general
                        echo "</tr>";
                        ?>
            </tbody>
        </table>
    </div>
</div>
</div>

</body></html>

<?php
$html = ob_get_clean(); // Captura el contenido HTML generado

// Configuración de DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('legal', 'landscape'); // Configura el tamaño y la orientación del papel
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream('Reporte Anual de Solicitud de Vales General - '.$year.'.pdf', ['Attachment' => 1]);
?>
