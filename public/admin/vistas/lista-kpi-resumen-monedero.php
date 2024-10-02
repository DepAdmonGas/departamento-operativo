<?php
require ('../../../app/help.php');

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];


//---------- OBTENER EL NOMBRE DE LA ESTACION ----------
function nombreES($GET_idEstacion, $con)
{
  $sql = "SELECT nombre FROM tb_estaciones WHERE id = '" . $GET_idEstacion . "' ";
  $result = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $Titulo = $row['nombre'];
  }

  return $Titulo;
}


//---------- MOSTRAR GRAFICA DE CORTE DIARIO (ANUAL) ----------
function mostrarGraficoFacturasMonederosYear($GET_idEstacion, $GET_year, $con)
{
  $data = obtenerDatosFacturasMonederosYear($GET_idEstacion, $GET_year, $con);

  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas de Monederos - ' . nombreES($GET_idEstacion, $con) . '';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_factura' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';


  echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');

function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
        var data = new google.visualization.DataTable();
        data.addColumn("string", "Mes");
        data.addColumn("number", "Puntaje Total");
        data.addColumn("number", "Puntaje Obtenido");
        data.addColumn({type: "string", role: "style"});

    data.addRows(' . json_encode($data['values']) . ');

    var options = {
         width: "100%", // Ancho al 100% para ser responsive
        height: "auto", // Altura automática
        legend: "none",
        hAxis: {
            title: "Meses",
        },
        vAxis: {
            title: "Puntaje Obtenido"
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_factura' . $GET_idEstacion . '' . $GET_year . '"));
    chart.draw(data, options);
}
</script>';
}


function obtenerDatosFacturasMonederosYear($GET_idEstacion, $GET_year, $con)
{

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 15;

  $totalEnero = consultaPuntajeMensual($GET_idEstacion, $GET_year, 1, $con);
  $totalFebrero = consultaPuntajeMensual($GET_idEstacion, $GET_year, 2, $con);
  $totalMarzo = consultaPuntajeMensual($GET_idEstacion, $GET_year, 3, $con);
  $totalAbril = consultaPuntajeMensual($GET_idEstacion, $GET_year, 4, $con);
  $totalMayo = consultaPuntajeMensual($GET_idEstacion, $GET_year, 5, $con);
  $totalJunio = consultaPuntajeMensual($GET_idEstacion, $GET_year, 6, $con);
  $totalJulio = consultaPuntajeMensual($GET_idEstacion, $GET_year, 7, $con);
  $totalAgosto = consultaPuntajeMensual($GET_idEstacion, $GET_year, 8, $con);
  $totalSeptiembre = consultaPuntajeMensual($GET_idEstacion, $GET_year, 9, $con);
  $totalOctubre = consultaPuntajeMensual($GET_idEstacion, $GET_year, 10, $con);
  $totalNoviembre = consultaPuntajeMensual($GET_idEstacion, $GET_year, 11, $con);
  $totalDiciembre = consultaPuntajeMensual($GET_idEstacion, $GET_year, 12, $con);

  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;
  $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

  $data = [
    'values' => [
      ['Enero', $totalPuntajeMensual, $totalEnero, '#dc3912'],
      ['Febrero', $totalPuntajeMensual, $totalFebrero, '#dc3912'],
      ['Marzo', $totalPuntajeMensual, $totalMarzo, '#dc3912'],
      ['Abril', $totalPuntajeMensual, $totalAbril, '#dc3912'],
      ['Mayo', $totalPuntajeMensual, $totalMayo, '#dc3912'],
      ['Junio', $totalPuntajeMensual, $totalJunio, '#dc3912'],
      ['Julio', $totalPuntajeMensual, $totalJulio, '#dc3912'],
      ['Agosto', $totalPuntajeMensual, $totalAgosto, '#dc3912'],
      ['Septiembre', $totalPuntajeMensual, $totalSeptiembre, '#dc3912'],
      ['Octubre', $totalPuntajeMensual, $totalOctubre, '#dc3912'],
      ['Noviembre', $totalPuntajeMensual, $totalNoviembre, '#dc3912'],
      ['Diciembre', $totalPuntajeMensual, $totalDiciembre, '#dc3912'],
      ['Anual', $totalPuntajeAnual, $totalAnual, '#dc3912']
    ]
  ];

  return $data;
}


function consultaPuntajeMensual($GET_idEstacion, $GET_year, $GET_mes, $con)
{

  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_monedero_documento.monedero,
    SUM(op_monedero_documento.puntaje) AS suma_puntajes,
    COUNT(op_monedero_documento.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_monedero_documento ON op_corte_mes.id = op_monedero_documento.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND op_corte_mes.mes = '" . $GET_mes . "'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_monedero_documento.monedero";

  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);
  $puntajeCalculo = 0;
  if ($numero_lista3 == 0) {
    $puntaje = 0;

  } else {

    while ($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)) {
      $puntajes = (int) $row_lista3['suma_puntajes'];
      $registros = (int) $row_lista3['cantidad_registros'];

      $calculoPuntaje = $puntajes / $registros;

      $puntajeCalculo = $puntajeCalculo + $calculoPuntaje;
    }

    $puntaje = $puntajeCalculo;

  }

  return $puntaje;

}



//---------- GRAFICAS TODAS LAS ESTACIONES ----------//
function obtenerEstacionesConPuntajeMasAlto($GET_year, $con)
{
  // Obtener los datos de apertura de todas las estaciones
  $data = obtenerDatosFacturasMonederoES($GET_year, $con);

  // Obtener las estaciones y sus aperturas
  $estaciones = array_column($data['values'], 0); // Nombres de las estaciones
  $aperturas = array_column($data['values'], 2); // Valores de apertura

  // Encontrar el puntaje más bajo
  $puntajeMasBajo = max($aperturas);

  // Encontrar los índices de las estaciones con el puntaje más bajo
  $indicesEstacionesMasBajas = array_keys($aperturas, $puntajeMasBajo);

  // Obtener las estaciones con el puntaje más bajo
  $estacionesMasBajas = array_intersect_key($estaciones, array_flip($indicesEstacionesMasBajas));

  return ['puntaje' => $puntajeMasBajo, 'estaciones' => $estacionesMasBajas];
}


function consultaFacturasMonederoES($GET_idEstacion, $GET_year, $con)
{

  $sql_lista3 = "SELECT
        op_corte_year.year,
        op_corte_year.id_estacion,
        op_corte_mes.mes,
        op_monedero_documento.monedero,
        SUM(op_monedero_documento.puntaje) AS suma_puntajes,
        COUNT(op_monedero_documento.id) AS cantidad_registros
        FROM
        op_corte_year 
        JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
        JOIN op_monedero_documento ON op_corte_mes.id = op_monedero_documento.id_mes
        WHERE
        op_corte_year.id_estacion = '" . $GET_idEstacion . "'
        AND op_corte_year.year = '" . $GET_year . "'
        GROUP BY
        op_corte_year.year,
        op_corte_year.id_estacion,
        op_corte_mes.mes,
        op_monedero_documento.monedero";

  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);
  $puntajeCalculo = 0;
  if ($numero_lista3 == 0) {
    $puntaje = 0;

  } else {

    while ($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)) {
      $puntajes = (int) $row_lista3['suma_puntajes'];
      $registros = (int) $row_lista3['cantidad_registros'];

      $calculoPuntaje = $puntajes / $registros;

      $puntajeCalculo = $puntajeCalculo + $calculoPuntaje;
    }

    $puntaje = $puntajeCalculo;

  }

  return $puntaje;

}


function mostrarGraficoFacturasMonederoES($GET_year, $con, $GET_idEstacion)
{
  $data = obtenerDatosFacturasMonederoES($GET_year, $con);
  $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($GET_year, $con);

  echo '<div class="col-12">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas de Monederos (Anual) - Estaciones';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_estaciones' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';



  echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');

        function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "Puntaje total");
            data.addColumn("number", "Puntaje obtenido");
            data.addColumn({type: "string", role: "style"}); // Nueva columna para los colores

            data.addRows(' . json_encode($data['values']) . ');

            var options = {
                 width: "100%", // Ancho al 100% para ser responsive
                height: "auto", // Altura automática
                legend: "none",
                                    title: "Estacion(es) con mejor cumplimiento: \n  ' . implode(", ", $mejorPuntaje['estaciones']) . ' - Puntaje: ' . $mejorPuntaje['puntaje'] . ' de 180",

                hAxis: {
                },
                vAxis: {
                    title: "Puntaje Obtenido"
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_estaciones' . $GET_idEstacion . '' . $GET_year . '"));
            chart.draw(data, options);
        }
    </script>';
}


function obtenerDatosFacturasMonederoES($GET_year, $con)
{
  $totalAperturasIN = consultaFacturasMonederoES(1, $GET_year, $con);
  $totalAperturasPS = consultaFacturasMonederoES(2, $GET_year, $con);
  $totalAperturasSA = consultaFacturasMonederoES(3, $GET_year, $con);
  $totalAperturasGA = consultaFacturasMonederoES(4, $GET_year, $con);
  $totalAperturasVG = consultaFacturasMonederoES(5, $GET_year, $con);
  $totalAperturasES = consultaFacturasMonederoES(6, $GET_year, $con);
  $totalAperturasXO = consultaFacturasMonederoES(7, $GET_year, $con);
  $totalAperturasBR = consultaFacturasMonederoES(14, $GET_year, $con);

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 15;
  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;


  $data = [
    'values' => [
      ['Interlomas', $totalPuntajeAnual, $totalAperturasIN, '#3366cc'],
      ['Palo Solo', $totalPuntajeAnual, $totalAperturasPS, '#dc3912'],
      ['San Agustin', $totalPuntajeAnual, $totalAperturasSA, '#ff9900'],
      ['Gasomira', $totalPuntajeAnual, $totalAperturasGA, '#109618'],
      ['Valle de Guadalupe', $totalPuntajeAnual, $totalAperturasVG, '#990099'],
      ['Esmegas', $totalPuntajeAnual, $totalAperturasES, '#0099c6'],
      ['Xochimilco', $totalPuntajeAnual, $totalAperturasXO, '#dd4477'],
      ['Bosque Real', $totalPuntajeAnual, $totalAperturasBR, '#66aa00']
    ]
  ];

  return $data;
}




?>





<div class="row">
  <!-- GRAFICA MENSUAL DE LA ESTACION -->
  <?php echo mostrarGraficoFacturasMonederosYear($GET_idEstacion, $GET_year, $con); ?>

  <!-- GRAFICA ANUAL DE TODAS LAS ESTACIONES -->
  <?php echo mostrarGraficoFacturasMonederoES($GET_year, $con, $GET_idEstacion) ?>

</div>