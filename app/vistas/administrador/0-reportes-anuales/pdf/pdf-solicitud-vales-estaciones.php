<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

$sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_estacion = mysqli_query($con, $sql_estacion);
while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
    $nombreES = $row_estacion['localidad'];	
}


// Genera el contenido HTML de la tabla
ob_start();
?>

<html>
<head>
    <style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url(<?=RUTA_IMG_LOGOS?>Fondo2.jpg); /* Usa la ruta correcta */
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

        .custom-table {
            width: 100%;
            font-size: .75em;
        }

        .custom-table thead th,
        .custom-table tbody td {
            text-align: left;
            padding: 10px;
            font-size: 10.5px;
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
<h2>Reporte Anual (<?=$nombreES?>), <?=$year?> <br> Solicitud de Vales</h2>

<div class="col-12">
    <div class="table-responsive">
        <table class="custom-table">
            <thead class="tables-bg">
                <tr>
                    <th style='text-align:center;'>Mes</th>
                    <th style='text-align:center;'>Monto</th>
                </tr>
            </thead>
            <tbody class="contenido-table-bg">
                <?php
                // Consulta SQL para una estación específica
                $sql_listadia = "SELECT 
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
                        AND id_estacion = $idEstacion
                        AND status != 0";

                $result_listadia = mysqli_query($con, $sql_listadia);
                $row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC);

                $totalesMes = [
                    'Enero' => $row_listadia['Ene'],
                    'Febrero' => $row_listadia['Feb'],
                    'Marzo' => $row_listadia['Mar'],
                    'Abril' => $row_listadia['Abr'],
                    'Mayo' => $row_listadia['May'],
                    'Junio' => $row_listadia['Jun'],
                    'Julio' => $row_listadia['Jul'],
                    'Agosto' => $row_listadia['Ago'],
                    'Septiembre' => $row_listadia['Sep'],
                    'Octubre' => $row_listadia['Oct'],
                    'Noviembre' => $row_listadia['Nov'],
                    'Diciembre' => $row_listadia['Dic'],
                ];

                // Mostrar los meses y montos en forma vertical
                foreach ($totalesMes as $mes => $monto) {
                    echo "<tr>
                            <th class='text-start fw-bold'>$mes</th>
                            <td style='text-align:right;'>$" . number_format($monto, 2) . "</td>
                          </tr>";
                }

                // Mostrar el total anual
                echo "<tr class='title-table-bg'>
                        <th class='text-start fw-bold'>Total Anual</th>
                        <td style='text-align:right;'><b>$" . number_format($row_listadia['TotalAnual'], 2) . "</b></td>
                      </tr>";
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>

<?php
$html = ob_get_clean(); // Captura el contenido HTML generado

// Configuración de DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Configura el tamaño y la orientación del papel en vertical
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream('Reporte Anual de Solicitud de Vales '.$nombreES.' - '.$year.'.pdf', ['Attachment' => 1]);

?>
