<?php
require ('../../../app/help.php');

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$tipo = $_GET['tipo'];


if ($tipo == 1) {
  $titulo = "Notas de Remision";

} else if ($tipo == 2) {
  $titulo = "Facturas";

} else if ($tipo == 3) {
  $titulo = "Facturas Ventas Mostrador";

} else if ($tipo == 4) {
  $titulo = "Fichas de Deposito Faltante";

}


//---------- OBTENER EL MEJOR PUNTAJE DE CUMPLIMIENTO DE LAS ESTACIONES ----------//
function obtenerEstacionesConPuntajeMasAlto($tipo, $GET_year, $con)
{
  // Obtener los datos de apertura de todas las estaciones
  if ($tipo == 1) {
    $data = obtenerDatosRemisionES($GET_year, $con);

  } else if ($tipo == 2) {
    $data = obtenerDatosFacturaES($GET_year, $con);

  } else if ($tipo == 3) {
    $data = obtenerDatosVentaMostradorES($GET_year, $con);

  } else if ($tipo == 4) {
    $data = obtenerDatosFaltantesAceitesES($GET_year, $con);

  }

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


//---------- MOSTRAR GRAFICA DE NOTAS DE REMISION (ANUAL) ----------
function mostrarGraficoRemisionYear($GET_idEstacion, $GET_year, $con)
{
  $data = obtenerDatosRemisionYear($GET_idEstacion, $GET_year, $con);

  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento Notas de Remición ' . nombreES($GET_idEstacion, $con) . '';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_remision' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
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

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_remision' . $GET_idEstacion . '' . $GET_year . '"));
        chart.draw(data, options);
    }
    </script>';
}


function obtenerDatosRemisionYear($GET_idEstacion, $GET_year, $con)
{

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 9;

  $totalEnero = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 1, $con);
  $totalFebrero = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 2, $con);
  $totalMarzo = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 3, $con);
  $totalAbril = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 4, $con);
  $totalMayo = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 5, $con);
  $totalJunio = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 6, $con);
  $totalJulio = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 7, $con);
  $totalAgosto = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 8, $con);
  $totalSeptiembre = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 9, $con);
  $totalOctubre = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 10, $con);
  $totalNoviembre = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 11, $con);
  $totalDiciembre = consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, 12, $con);

  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;
  $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

  $data = [
    'values' => [
      ['Enero', $totalPuntajeMensual, $totalEnero, '#ca6ed0'],
      ['Febrero', $totalPuntajeMensual, $totalFebrero, '#dc3912'],
      ['Marzo', $totalPuntajeMensual, $totalMarzo, '#ff9900'],
      ['Abril', $totalPuntajeMensual, $totalAbril, '#109618'],
      ['Mayo', $totalPuntajeMensual, $totalMayo, '#990099'],
      ['Junio', $totalPuntajeMensual, $totalJunio, '#0099c6'],
      ['Julio', $totalPuntajeMensual, $totalJulio, '#dd4477'],
      ['Agosto', $totalPuntajeMensual, $totalAgosto, '#66aa00'],
      ['Septiembre', $totalPuntajeMensual, $totalSeptiembre, '#b82e2e'],
      ['Octubre', $totalPuntajeMensual, $totalOctubre, '#316395'],
      ['Noviembre', $totalPuntajeMensual, $totalNoviembre, '#994499'],
      ['Diciembre', $totalPuntajeMensual, $totalDiciembre, '#22aa99'],
      ['Anual', $totalPuntajeAnual, $totalAnual, '#FFD300']
    ]
  ];

  return $data;
}


function consultaPuntajeRemisionMes($GET_idEstacion, $GET_year, $GET_mes, $con)
{

  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo,
    SUM(op_aceites_factura.puntaje) AS suma_puntajes,
    COUNT(op_aceites_factura.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_factura ON op_corte_mes.id = op_aceites_factura.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND op_corte_mes.mes = '" . $GET_mes . "'
	AND nombre_anexo LIKE '%Nota%'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo;";

  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);

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



//---------- MOSTRAR GRAFICA DE NOTAS DE REMISION (TODAS LAS ESTACIONES) ----------
function mostrarGraficoRemisionES($tipo, $GET_year, $con)
{
  $data = obtenerDatosRemisionES($GET_year, $con);
  $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($tipo, $GET_year, $con);

  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Notas de Remisión (Anual) - Estaciones';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_remision_ES' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';

  echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $GET_year . ');
    
    function drawChart' . $GET_year . '() {
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
                            title: "Estacion(es) con mejor cumplimiento: \n  ' . implode(", ", $mejorPuntaje['estaciones']) . ' - Puntaje: ' . $mejorPuntaje['puntaje'] . ' de 108",

        hAxis: {
        },
        vAxis: {
            title: "Puntaje Obtenido"
        }
        };
    
        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_remision_ES' . $GET_year . '"));
        chart.draw(data, options);
        }
    </script>';
}


function obtenerDatosRemisionES($GET_year, $con)
{
  $totalAperturasIN = consultaRemisionES(1, $GET_year, $con);
  $totalAperturasPS = consultaRemisionES(2, $GET_year, $con);
  $totalAperturasSA = consultaRemisionES(3, $GET_year, $con);
  $totalAperturasGA = consultaRemisionES(4, $GET_year, $con);
  $totalAperturasVG = consultaRemisionES(5, $GET_year, $con);
  $totalAperturasES = consultaRemisionES(6, $GET_year, $con);
  $totalAperturasXO = consultaRemisionES(7, $GET_year, $con);
  $totalAperturasBR = consultaRemisionES(14, $GET_year, $con);

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 9;
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


function consultaRemisionES($GET_idEstacion, $GET_year, $con)
{

  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo,
    SUM(op_aceites_factura.puntaje) AS suma_puntajes,
    COUNT(op_aceites_factura.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_factura ON op_corte_mes.id = op_aceites_factura.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND nombre_anexo LIKE '%Nota%'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo;";

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


//---------- MOSTRAR GRAFICA DE FACTURAS (TODAS LAS ESTACIONES) ----------
function mostrarGraficoFacturaYear($GET_idEstacion, $GET_year, $con)
{
  $data = obtenerDatosFacturaYear($GET_idEstacion, $GET_year, $con);
  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas - ' . nombreES($GET_idEstacion, $con) . '';
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
            width: "100%",
            height: "auto",
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


function obtenerDatosFacturaYear($GET_idEstacion, $GET_year, $con)
{

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 9;

  $totalEnero = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 1, $con);
  $totalFebrero = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 2, $con);
  $totalMarzo = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 3, $con);
  $totalAbril = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 4, $con);
  $totalMayo = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 5, $con);
  $totalJunio = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 6, $con);
  $totalJulio = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 7, $con);
  $totalAgosto = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 8, $con);
  $totalSeptiembre = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 9, $con);
  $totalOctubre = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 10, $con);
  $totalNoviembre = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 11, $con);
  $totalDiciembre = consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, 12, $con);

  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;
  $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

  $data = [
    'values' => [
      ['Enero', $totalPuntajeMensual, $totalEnero, '#ca6ed0'],
      ['Febrero', $totalPuntajeMensual, $totalFebrero, '#dc3912'],
      ['Marzo', $totalPuntajeMensual, $totalMarzo, '#ff9900'],
      ['Abril', $totalPuntajeMensual, $totalAbril, '#109618'],
      ['Mayo', $totalPuntajeMensual, $totalMayo, '#990099'],
      ['Junio', $totalPuntajeMensual, $totalJunio, '#0099c6'],
      ['Julio', $totalPuntajeMensual, $totalJulio, '#dd4477'],
      ['Agosto', $totalPuntajeMensual, $totalAgosto, '#66aa00'],
      ['Septiembre', $totalPuntajeMensual, $totalSeptiembre, '#b82e2e'],
      ['Octubre', $totalPuntajeMensual, $totalOctubre, '#316395'],
      ['Noviembre', $totalPuntajeMensual, $totalNoviembre, '#994499'],
      ['Diciembre', $totalPuntajeMensual, $totalDiciembre, '#22aa99'],
      ['Anual', $totalPuntajeAnual, $totalAnual, '#FFD300']
    ]
  ];

  return $data;
}


function consultaPuntajeFacturaMes($GET_idEstacion, $GET_year, $GET_mes, $con)
{

  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo,
    SUM(op_aceites_factura.puntaje) AS suma_puntajes,
    COUNT(op_aceites_factura.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_factura ON op_corte_mes.id = op_aceites_factura.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND op_corte_mes.mes = '" . $GET_mes . "'
	AND nombre_anexo LIKE '%Factura%'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo";

  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);

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


//---------- MOSTRAR GRAFICA DE FACTURAS (TODAS LAS ESTACIONES) ----------
function mostrarGraficoFacturaES($tipo, $GET_year, $con)
{
  $data = obtenerDatosFacturaES($GET_year, $con);
  $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($tipo, $GET_year, $con);

  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas (Anual) - Estaciones';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_factura_ES' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';

  echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_year . ');
        
        function drawChart' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "Puntaje Total");
            data.addColumn("number", "Puntaje Obtenido");
            data.addColumn({type: "string", role: "style"});
        
            data.addRows(' . json_encode($data['values']) . ');
        
            var options = {
            width: "100%",
            height: "auto",
            legend: "none",
                            title: "Estacion(es) con mejor cumplimiento: \n  ' . implode(", ", $mejorPuntaje['estaciones']) . ' - Puntaje: ' . $mejorPuntaje['puntaje'] . ' de 108",

            hAxis: {
            },
            vAxis: {
                title: "Puntaje Obtenido"
            }
            };
        
            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_factura_ES' . $GET_year . '"));
            chart.draw(data, options);
            }
        </script>';
}


function obtenerDatosFacturaES($GET_year, $con)
{
  $totalAperturasIN = consultaFacturaES(1, $GET_year, $con);
  $totalAperturasPS = consultaFacturaES(2, $GET_year, $con);
  $totalAperturasSA = consultaFacturaES(3, $GET_year, $con);
  $totalAperturasGA = consultaFacturaES(4, $GET_year, $con);
  $totalAperturasVG = consultaFacturaES(5, $GET_year, $con);
  $totalAperturasES = consultaFacturaES(6, $GET_year, $con);
  $totalAperturasXO = consultaFacturaES(7, $GET_year, $con);
  $totalAperturasBR = consultaFacturaES(14, $GET_year, $con);

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 9;
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


function consultaFacturaES($GET_idEstacion, $GET_year, $con)
{

  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo,
    SUM(op_aceites_factura.puntaje) AS suma_puntajes,
    COUNT(op_aceites_factura.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_factura ON op_corte_mes.id = op_aceites_factura.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND nombre_anexo LIKE '%Factura%'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_factura.nombre_anexo";

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



//---------- MOSTRAR GRAFICA DE FACTURAS VENTA MOSTRADOR (ANUAL) ----------
function mostrarGraficoVentaMostrador($GET_idEstacion, $GET_year, $con)
{
  $data = obtenerDatosVentaMostrador($GET_idEstacion, $GET_year, $con);
  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas Venta Mostrador - ' . nombreES($GET_idEstacion, $con) . '';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_factura_venta' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
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
            width: "100%",
            height: "auto",
            legend: "none",
            hAxis: {
                title: "Meses",
            },
            vAxis: {
                title: "Puntaje Obtenido"
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_factura_venta' . $GET_idEstacion . '' . $GET_year . '"));
        chart.draw(data, options);
    }
    </script>';

}


function obtenerDatosVentaMostrador($GET_idEstacion, $GET_year, $con)
{

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 3;

  $totalEnero = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 1, $con);
  $totalFebrero = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 2, $con);
  $totalMarzo = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 3, $con);
  $totalAbril = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 4, $con);
  $totalMayo = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 5, $con);
  $totalJunio = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 6, $con);
  $totalJulio = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 7, $con);
  $totalAgosto = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 8, $con);
  $totalSeptiembre = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 9, $con);
  $totalOctubre = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 10, $con);
  $totalNoviembre = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 11, $con);
  $totalDiciembre = consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, 12, $con);

  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;
  $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

  $data = [
    'values' => [
      ['Enero', $totalPuntajeMensual, $totalEnero, '#ca6ed0'],
      ['Febrero', $totalPuntajeMensual, $totalFebrero, '#dc3912'],
      ['Marzo', $totalPuntajeMensual, $totalMarzo, '#ff9900'],
      ['Abril', $totalPuntajeMensual, $totalAbril, '#109618'],
      ['Mayo', $totalPuntajeMensual, $totalMayo, '#990099'],
      ['Junio', $totalPuntajeMensual, $totalJunio, '#0099c6'],
      ['Julio', $totalPuntajeMensual, $totalJulio, '#dd4477'],
      ['Agosto', $totalPuntajeMensual, $totalAgosto, '#66aa00'],
      ['Septiembre', $totalPuntajeMensual, $totalSeptiembre, '#b82e2e'],
      ['Octubre', $totalPuntajeMensual, $totalOctubre, '#316395'],
      ['Noviembre', $totalPuntajeMensual, $totalNoviembre, '#994499'],
      ['Diciembre', $totalPuntajeMensual, $totalDiciembre, '#22aa99'],
      ['Anual', $totalPuntajeAnual, $totalAnual, '#FFD300']
    ]
  ];

  return $data;
}


function consultaPuntajeVentaMostradorMes($GET_idEstacion, $GET_year, $GET_mes, $con)
{

  $sql_lista3 = "SELECT
	op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
	SUM(op_aceites_documento.puntaje_ficha) AS suma_puntajes,
    COUNT(op_aceites_documento.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_documento ON op_corte_mes.id = op_aceites_documento.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND op_corte_mes.mes = '" . $GET_mes . "'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_documento.ficha_deposito";

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


//---------- MOSTRAR GRAFICA DE FACTURAS VENTA MOSTRADOR (TODAS LAS ESTACIONES) ----------
function mostrarGraficoVentaMostradorES($tipo, $GET_year, $con)
{
  $data = obtenerDatosVentaMostradorES($GET_year, $con);
  $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($tipo, $GET_year, $con);

  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas Venta Mostrador (Anual)';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_factura_venta_ES' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';

  echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_year . ');
        
        function drawChart' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "Puntaje Total");
            data.addColumn("number", "Puntaje Obtenido");
            data.addColumn({type: "string", role: "style"});
        
            data.addRows(' . json_encode($data['values']) . ');
        
            var options = {
            width: "100%",
            height: "auto",
            legend: "none",
            title: "Estacion(es) con mejor cumplimiento: \n  ' . implode(", ", $mejorPuntaje['estaciones']) . ' - Puntaje: ' . $mejorPuntaje['puntaje'] . ' de 36",

            vAxis: {
                title: "Puntaje Obtenido"
            }
            };
        
            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_factura_venta_ES' . $GET_year . '"));
            chart.draw(data, options);
            }
        </script>';
}


function obtenerDatosVentaMostradorES($GET_year, $con)
{
  $totalAperturasIN = consultaVentaMostradorES(1, $GET_year, $con);
  $totalAperturasPS = consultaVentaMostradorES(2, $GET_year, $con);
  $totalAperturasSA = consultaVentaMostradorES(3, $GET_year, $con);
  $totalAperturasGA = consultaVentaMostradorES(4, $GET_year, $con);
  $totalAperturasVG = consultaVentaMostradorES(5, $GET_year, $con);
  $totalAperturasES = consultaVentaMostradorES(6, $GET_year, $con);
  $totalAperturasXO = consultaVentaMostradorES(7, $GET_year, $con);
  $totalAperturasBR = consultaVentaMostradorES(14, $GET_year, $con);

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 3;
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


function consultaVentaMostradorES($GET_idEstacion, $GET_year, $con)
{

  $sql_lista3 = "SELECT
	op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
	SUM(op_aceites_documento.puntaje_ficha) AS suma_puntajes,
    COUNT(op_aceites_documento.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_documento ON op_corte_mes.id = op_aceites_documento.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_documento.ficha_deposito";

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


//---------- MOSTRAR GRAFICA FALTANTES DE ACEITES (ANUAL) ----------
function mostrarGraficoFaltantesAceites($GET_idEstacion, $GET_year, $con)
{
  $data = obtenerDatosFaltantesAceites($GET_idEstacion, $GET_year, $con);
  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Fichas de Deposito Faltante - ' . nombreES($GET_idEstacion, $con) . '';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_faltantes_aceites' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
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
            width: "100%",
            height: "auto",
            legend: "none",
            hAxis: {
                title: "Meses",
            },
            vAxis: {
                title: "Puntaje Obtenido"
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_faltantes_aceites' . $GET_idEstacion . '' . $GET_year . '"));
        chart.draw(data, options);
    }
    </script>';

}


function obtenerDatosFaltantesAceites($GET_idEstacion, $GET_year, $con)
{

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 3;

  $totalEnero = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 1, $con);
  $totalFebrero = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 2, $con);
  $totalMarzo = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 3, $con);
  $totalAbril = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 4, $con);
  $totalMayo = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 5, $con);
  $totalJunio = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 6, $con);
  $totalJulio = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 7, $con);
  $totalAgosto = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 8, $con);
  $totalSeptiembre = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 9, $con);
  $totalOctubre = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 10, $con);
  $totalNoviembre = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 11, $con);
  $totalDiciembre = consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, 12, $con);

  //---------- ANUAL ----------- 
  $totalPuntajeAnual = $totalPuntajeMensual * 12;
  $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

  $data = [
    'values' => [
      ['Enero', $totalPuntajeMensual, $totalEnero, '#ca6ed0'],
      ['Febrero', $totalPuntajeMensual, $totalFebrero, '#dc3912'],
      ['Marzo', $totalPuntajeMensual, $totalMarzo, '#ff9900'],
      ['Abril', $totalPuntajeMensual, $totalAbril, '#109618'],
      ['Mayo', $totalPuntajeMensual, $totalMayo, '#990099'],
      ['Junio', $totalPuntajeMensual, $totalJunio, '#0099c6'],
      ['Julio', $totalPuntajeMensual, $totalJulio, '#dd4477'],
      ['Agosto', $totalPuntajeMensual, $totalAgosto, '#66aa00'],
      ['Septiembre', $totalPuntajeMensual, $totalSeptiembre, '#b82e2e'],
      ['Octubre', $totalPuntajeMensual, $totalOctubre, '#316395'],
      ['Noviembre', $totalPuntajeMensual, $totalNoviembre, '#994499'],
      ['Diciembre', $totalPuntajeMensual, $totalDiciembre, '#22aa99'],
      ['Anual', $totalPuntajeAnual, $totalAnual, '#FFD300']
    ]
  ];

  return $data;
}


function consultaPuntajeFaltantesAceitesMes($GET_idEstacion, $GET_year, $GET_mes, $con)
{

  $sql_lista3 = "SELECT
	op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
	SUM(op_aceites_documento.puntaje_factura) AS suma_puntajes,
    COUNT(op_aceites_documento.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_documento ON op_corte_mes.id = op_aceites_documento.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    AND op_corte_mes.mes = '" . $GET_mes . "'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_documento.factura_venta";

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



//---------- MOSTRAR GRAFICA DE FACTURAS VENTA MOSTRADOR (TODAS LAS ESTACIONES) ----------
function mostrarGraficoFaltantesAceitesES($tipo, $GET_year, $con)
{
  $data = obtenerDatosFaltantesAceitesES($GET_year, $con);
  $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($tipo, $GET_year, $con);
  echo '<div class="col-12 mb-3">';
  echo '<div class="table-responsive">';
  echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
  echo '<thead class="tables-bg">';
  echo '<tr>';
  echo '<th class="align-middle text-center">';
  echo 'Cumplimiento de Facturas Venta Mostrador (Anual) - Estaciones ';
  echo '</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody class="bg-white">';
  echo '<tr>';
  echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
  echo '<div id="chart_div_faltantes_aceites_ES' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
  echo '</th>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
  echo '</div>';

  echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_year . ');
        
        function drawChart' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "Puntaje Total");
            data.addColumn("number", "Puntaje Obtenido");
            data.addColumn({type: "string", role: "style"});
        
            data.addRows(' . json_encode($data['values']) . ');
        
            var options = {
            width: "100%",
            height: "auto",
            legend: "none",
                title: "Estacion(es) con mejor cumplimiento: \n  ' . implode(", ", $mejorPuntaje['estaciones']) . ' - Puntaje: ' . $mejorPuntaje['puntaje'] . ' de 36",
            hAxis: {
            },
            vAxis: {
                title: "Puntaje Obtenido"
            }
            };
        
            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_faltantes_aceites_ES' . $GET_year . '"));
            chart.draw(data, options);
            }
        </script>';
}


function obtenerDatosFaltantesAceitesES($GET_year, $con)
{
  $totalAperturasIN = consultaFaltantesAceitesES(1, $GET_year, $con);
  $totalAperturasPS = consultaFaltantesAceitesES(2, $GET_year, $con);
  $totalAperturasSA = consultaFaltantesAceitesES(3, $GET_year, $con);
  $totalAperturasGA = consultaFaltantesAceitesES(4, $GET_year, $con);
  $totalAperturasVG = consultaFaltantesAceitesES(5, $GET_year, $con);
  $totalAperturasES = consultaFaltantesAceitesES(6, $GET_year, $con);
  $totalAperturasXO = consultaFaltantesAceitesES(7, $GET_year, $con);
  $totalAperturasBR = consultaFaltantesAceitesES(14, $GET_year, $con);

  //---------- MENSUAL ----------
  $totalPuntajeMensual = 3;
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


function consultaFaltantesAceitesES($GET_idEstacion, $GET_year, $con)
{


  $sql_lista3 = "SELECT
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    SUM(op_aceites_documento.puntaje_factura) AS suma_puntajes,
    COUNT(op_aceites_documento.id) AS cantidad_registros
    FROM
    op_corte_year 
    JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
    JOIN op_aceites_documento ON op_corte_mes.id = op_aceites_documento.id_mes
    WHERE
    op_corte_year.id_estacion = '" . $GET_idEstacion . "'
    AND op_corte_year.year = '" . $GET_year . "'
    GROUP BY
    op_corte_year.year,
    op_corte_year.id_estacion,
    op_corte_mes.mes,
    op_aceites_documento.factura_venta";

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





?>


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-chevron-left"></i> Resumen Aceites</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase"> Evaluación <?= $titulo ?>
      </li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Evaluación <?= $titulo ?>
      </h3>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
      <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="InfoEvaluacion(<?= $tipo ?>)">
        <span class="btn-label2"><i class="fa fa-info"></i></span>Evaluacion</button>
    </div>

  </div>

  <hr>

</div>

<div class="row">

  <?php

  if ($tipo == 1) {
    $kpiMensual = mostrarGraficoRemisionYear($GET_idEstacion, $GET_year, $con);
    $kpiAnual = mostrarGraficoRemisionES($tipo, $GET_year, $con);

  } else if ($tipo == 2) {
    $kpiMensual = mostrarGraficoFacturaYear($GET_idEstacion, $GET_year, $con);
    $kpiAnual = mostrarGraficoFacturaES($tipo, $GET_year, $con);

  } else if ($tipo == 3) {
    $kpiMensual = mostrarGraficoVentaMostrador($GET_idEstacion, $GET_year, $con);
    $kpiAnual = mostrarGraficoVentaMostradorES($tipo, $GET_year, $con);

  } else if ($tipo == 4) {
    $kpiMensual = mostrarGraficoFaltantesAceites($GET_idEstacion, $GET_year, $con);
    $kpiAnual = mostrarGraficoFaltantesAceitesES($tipo, $GET_year, $con);

  }

  ?>

</div>