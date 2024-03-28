<?php
require('../../../app/help.php');

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 


  //---------- OBTENER EL NOMBRE DE LA ESTACION ----------
  function nombreES($GET_idEstacion,$con){
    $sql = "SELECT nombre FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $Titulo = $row['nombre'];
    }

    return $Titulo;
  }


function consultaAperturaMensual($GET_idEstacion,$GET_year,$GET_mes,$con){
    
    $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_corte_dia.id,
    op_corte_dia_hist.fecha AS fecha_apertura,
    op_corte_dia_hist.detalle
    FROM op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes
    JOIN op_corte_dia_hist ON op_corte_dia.id = op_corte_dia_hist.id_corte
    WHERE
    op_corte_year.id_estacion = '".$GET_idEstacion."' AND
	op_corte_year.year = '".$GET_year."' AND op_corte_mes.mes = '".$GET_mes."'";

    $result_lista3 = mysqli_query($con, $sql_lista3);
    return $numero_lista3 = mysqli_num_rows($result_lista3);
 
} 

   

//---------- MOSTRAR GRAFICA DE CORTE DIARIO (ANUAL) ----------
function mostrarGraficoCorteDiarioYear($GET_idEstacion, $GET_year, $con) {
    $data = obtenerDatosCorteDiarioYear($GET_idEstacion, $GET_year, $con);

    echo '<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">';
    echo '<div class="border p-0">';
    echo '<div class="table-responsive">';
    echo '<div id="chart_div' . $GET_idEstacion . '' . $GET_year . '"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');

        function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "No. de Aperturas");
            data.addColumn({type: "string", role: "style"}); // Nueva columna para los colores

            data.addRows(' . json_encode($data['values']) . ');

            
            var options = {
                width: "auto",
                height: 700,
                legend: "none",
                colors: ' . json_encode($data['colors']) . ',
                title: "No. de apertuas - '.nombreES($GET_idEstacion,$con).' \n\n", // Agrega el salto de línea con \n
                hAxis: {
                    title: "Meses"
                },
                vAxis: {
                    title: "No. de Aperturas"
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div' . $GET_idEstacion . '' . $GET_year . '"));
            chart.draw(data, options);
        }

    </script>';


}

function obtenerDatosCorteDiarioYear($GET_idEstacion, $GET_year, $con) {
    $totalAperturasEnero = consultaAperturaMensual($GET_idEstacion,$GET_year,1,$con);
    $totalAperturasFebrero = consultaAperturaMensual($GET_idEstacion,$GET_year,2,$con);
    $totalAperturasMarzo = consultaAperturaMensual($GET_idEstacion,$GET_year,3,$con);
    $totalAperturasAbril = consultaAperturaMensual($GET_idEstacion,$GET_year,4,$con);
    $totalAperturasMayo = consultaAperturaMensual($GET_idEstacion,$GET_year,5,$con);
    $totalAperturasJunio = consultaAperturaMensual($GET_idEstacion,$GET_year,6,$con);
    $totalAperturasJulio = consultaAperturaMensual($GET_idEstacion,$GET_year,7,$con);
    $totalAperturasAgosto = consultaAperturaMensual($GET_idEstacion,$GET_year,8,$con);
    $totalAperturasSeptiembre = consultaAperturaMensual($GET_idEstacion,$GET_year,9,$con);
    $totalAperturasOctubre = consultaAperturaMensual($GET_idEstacion,$GET_year,10,$con);
    $totalAperturasNoviembre = consultaAperturaMensual($GET_idEstacion,$GET_year,11,$con);
    $totalAperturasDiciembre = consultaAperturaMensual($GET_idEstacion,$GET_year,12,$con);

    $totalAperturaAnual = $totalAperturasEnero + $totalAperturasFebrero + $totalAperturasMarzo + $totalAperturasAbril + $totalAperturasMayo + $totalAperturasJunio + 
    $totalAperturasJulio + $totalAperturasAgosto + $totalAperturasSeptiembre + $totalAperturasOctubre + $totalAperturasNoviembre + $totalAperturasDiciembre;

    $data = [
        'values' => [
            ['Enero', $totalAperturasEnero, '#3366cc'],
            ['Febrero', $totalAperturasFebrero, '#dc3912'],
            ['Marzo', $totalAperturasMarzo, '#ff9900'],
            ['Abril', $totalAperturasAbril, '#109618'],
            ['Mayo', $totalAperturasMayo, '#990099'],
            ['Junio', $totalAperturasJunio, '#0099c6'],
            ['Julio', $totalAperturasJulio, '#dd4477'],
            ['Agosto', $totalAperturasAgosto, '#66aa00'],
            ['Septiembre', $totalAperturasSeptiembre, '#b82e2e'],
            ['Octubre', $totalAperturasOctubre, '#316395'],
            ['Noviembre', $totalAperturasNoviembre, '#994499'],
            ['Diciembre', $totalAperturasDiciembre, '#22aa99'],
            ['Anual', $totalAperturaAnual, '#FFD300']
        ]
    ];

    return $data;
}


//---------- GRAFICAS TODAS LAS ESTACIONES ----------//
function obtenerEstacionesConPuntajeMasBajo($GET_year, $con) {
    // Obtener los datos de apertura de todas las estaciones
    $data = obtenerDatosCorteDiarioES($GET_year, $con);

    // Obtener las estaciones y sus aperturas
    $estaciones = array_column($data['values'], 0); // Nombres de las estaciones
    $aperturas = array_column($data['values'], 1); // Valores de apertura

    // Encontrar el puntaje más bajo
    $puntajeMasBajo = min($aperturas);

    // Encontrar los índices de las estaciones con el puntaje más bajo
    $indicesEstacionesMasBajas = array_keys($aperturas, $puntajeMasBajo);

    // Obtener las estaciones con el puntaje más bajo
    $estacionesMasBajas = array_intersect_key($estaciones, array_flip($indicesEstacionesMasBajas));

    return ['puntaje' => $puntajeMasBajo, 'estaciones' => $estacionesMasBajas];
}


function consultaAperturaES($GET_idEstacion,$GET_year,$con){
    
    $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_corte_dia.id,
    op_corte_dia_hist.fecha AS fecha_apertura,
    op_corte_dia_hist.detalle
    FROM op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes
    JOIN op_corte_dia_hist ON op_corte_dia.id = op_corte_dia_hist.id_corte
    WHERE
    op_corte_year.id_estacion = '".$GET_idEstacion."' AND
	op_corte_year.year = '".$GET_year."'";

    $result_lista3 = mysqli_query($con, $sql_lista3);
    return $numero_lista3 = mysqli_num_rows($result_lista3);
 
} 


function mostrarGraficoCorteDiarioES($GET_year, $con) {
    $data = obtenerDatosCorteDiarioES($GET_year, $con);
    $mejorPuntaje = obtenerEstacionesConPuntajeMasBajo($GET_year, $con);

    echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">';
    echo '<div class="border p-0">';
    echo '<div class="table-responsive">';
    echo '<div id="chart_div_general' . $GET_idEstacion . '' . $GET_year . '"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>'; 

    echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');

        function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "No. de Aperturas");
            data.addColumn({type: "string", role: "style"}); // Nueva columna para los colores

            data.addRows(' . json_encode($data['values']) . ');

            var options = {
                width: "auto",
                height: 700,
                legend: "none",
                colors: ' . json_encode($data['colors']) . ',
                title: "No. de aperturas (Anual) - Estaciones\n\n",
                hAxis: {
                    title: "Estacion(es) con menor numero de aperturas: \n  '.implode(", ", $mejorPuntaje['estaciones']).' - Aperturas: '.$mejorPuntaje['puntaje'].'",
                },
                vAxis: {
                    title: "No. de Aperturas"
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_general' . $GET_idEstacion . '' . $GET_year . '"));
            chart.draw(data, options);
        }
    </script>';
}





function obtenerDatosCorteDiarioES($GET_year, $con) {
    $totalAperturasIN = consultaAperturaES(1,$GET_year,$con);
    $totalAperturasPS = consultaAperturaES(2,$GET_year,$con);
    $totalAperturasSA = consultaAperturaES(3,$GET_year,$con);
    $totalAperturasGA = consultaAperturaES(4,$GET_year,$con);
    $totalAperturasVG = consultaAperturaES(5,$GET_year,$con);
    $totalAperturasES = consultaAperturaES(6,$GET_year,$con);
    $totalAperturasXO = consultaAperturaES(7,$GET_year,$con);
    $totalAperturasBR = consultaAperturaES(14,$GET_year,$con);

    $data = [
        'values' => [
            ['Interlomas', $totalAperturasIN, '#3366cc'],
            ['Palo Solo', $totalAperturasPS, '#dc3912'],
            ['San Agustin', $totalAperturasSA, '#ff9900'],
            ['Gasomira', $totalAperturasGA, '#109618'],
            ['Valle de Guadalupe', $totalAperturasVG, '#990099'],
            ['Esmegas', $totalAperturasES, '#0099c6'],
            ['Xochimilco', $totalAperturasXO, '#dd4477'],
            ['Bosque Real', $totalAperturasBR, '#66aa00']
        ]
    ];

    return $data;
}




?>

 
<div class="row">
<!-- GRAFICA MENSUAL DE LA ESTACION -->
<?php echo mostrarGraficoCorteDiarioYear($GET_idEstacion,$GET_year,$con)?>


<!-- GRAFICA ANUAL DE TODAS LAS ESTACIONES -->
<?php echo mostrarGraficoCorteDiarioES($GET_year,$con)?>


</div>


